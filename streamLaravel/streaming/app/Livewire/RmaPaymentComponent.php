<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Services\RmaPaymentService;
use App\Models\Payment;

class RmaPaymentComponent extends Component
{

    public $bfsMsgType;
    public $bankList;
    private $bfsTxnId;
    #[Validate('required')]
    public $account_number;
    #[Validate('required')]
    public $bank;
    #[Validate('required')]
    public $fullname;
    #[Validate('required')]
    public $email;
    // #[Validate('required')]
    public $otp, $otp_inputs=[];
    public $arResponse = null;
    public $aeResponse = null;
    public $drResponse = null;
    public $price;
    public $code; 
    public $productName;
    public $isLoadingNotifier = false;

    public function mount(){
        $this->productName = "Movie";
        $this->price = 1;
        $this->setRequestType('AR');
        $this->makePaymentAR();
    }

    public function render()
    {
        return view('livewire.rma.payment-component');
    }


    private function setRequestType($requestType) {
        $this->bfsMsgType = $requestType;
    }


    private function makePaymentAR() {
        $this->isLoadingNotifier = true;
        $bfsTxnAmount = $this->price;
        $package = $this->productName;
        $query = 'query {
            makeArRequest(input: {
                remitter_email: "",
                amount: "' . $bfsTxnAmount . '",
                package: "' . $package . '"
            }) {
                data
                error {
                    code
                    message
                }
            }
        }';
        $response = (new RmaPaymentService)->makePaymentRequest($query);
        // dd(json_decode($response->getBody(),true));
        try {
            $responseBody = json_decode($response->getBody(),true);
            $jsonData = $responseBody['data']['makeArRequest'];
            if ($jsonData['data'] !== null) {
                parse_str($jsonData['data'], $this->arResponse);
                $this->getBanks();
            } else {
                $this->arResponse = [
                    "bfs_responseCode" => "-2",
                    "bfs_responseDesc" => "Sorry, something went wrong. Please, try after sometime."
                ];
            }
        } catch (\Exception $error) {
            $this->arResponse = [
                "bfs_responseCode" => "-1",
                "bfs_responseDesc" => "Sorry, something went wrong. Please, try after sometime."
            ];
        }
        // dd($this->arResponse);
        $this->isLoadingNotifier = false;
    }

    private function getBanks(){
        $bankListRaw = urldecode(
        $this->arResponse['bfs_bankList'] ?? ''
        );

        $banksRaw = explode('~A#', $bankListRaw);

        $this->bankList = array_map(function ($bankRaw) use ($banksRaw) {
        $bankDetails = explode('~', $bankRaw);
        return [
            "code" => !empty($bankDetails) ? $bankDetails[0] : '',
            "name" => count($bankDetails) > 1 ? $bankDetails[1] : '',
            "status" => count($bankDetails) > 2 ? $bankDetails[2] : '',
        ];
        }, $banksRaw);
    }

    public function makePaymentRequest(){
        $this->validate();
        // dd($this->validate());
        $this->isLoadingNotifier = true;
        $this->otp_inputs = array_fill(0, 6, '');
        $this->setRequestType('AE');
        $this->makePaymentAE();

    }

    public function cancelPaymentRequest(){
       return  redirect()->route('home');
    }

    // private function makePaymentAE() {
    //     $query = 'query {
    //         makeAeRequest(input: {
    //             txn_id:  "' .$this->arResponse['bfs_bfsTxnId']. '"
    //             remitter_bank_id:  "' .$this->bank. '"
    //             remitter_acc_no:  "' .$this->account_number. '"
    //         }) {
    //             data
    //             error {
    //                 code
    //                 message
    //             }
    //         }
    //     }';

    //     $response = (new RmaPaymentService)->makePaymentRequest($query);
    //     // dd(json_decode($response->getBody(),true));
    //     try {
    //         $responseBody = json_decode($response->getBody(),true);
    //         $jsonData = $responseBody['data']['makeAeRequest'];
    //         if ($jsonData['data'] !== null) {
    //             parse_str($jsonData['data'], $this->aeResponse);

    //         } else {
    //             $this->aeResponse = [
    //                 "bfs_responseCode" => "-2",
    //                 "bfs_responseDesc" => "Sorry, something went wrong. Please, try after sometime."
    //             ];
    //         }
    //     } catch (\Exception $error) {
    //         $this->aeResponse = [
    //             "bfs_responseCode" => "-1",
    //             "bfs_responseDesc" => "Sorry, something went wrong. Please, try after sometime."
    //         ];
    //     }

    //     $this->isLoadingNotifier = false;
    // }

    private function makePaymentAE() {
        $query = 'query {
            makeAeRequest(input: {
                txn_id:  "' .$this->arResponse['bfs_bfsTxnId']. '"
                remitter_bank_id:  "' .$this->bank. '"
                remitter_acc_no:  "' .$this->account_number. '"
            }) {
                data
                error {
                    code
                    message
                }
            }
        }';

        $response = (new RmaPaymentService)->makePaymentRequest($query);

        try {
            $responseBody = json_decode($response->getBody(), true);
            $jsonData = $responseBody['data']['makeAeRequest'];

            if ($jsonData['data'] !== null) {
                parse_str($jsonData['data'], $this->aeResponse);
            } else {
                $this->aeResponse = [
                    "bfs_responseCode" => "-2",
                    "bfs_responseDesc" => "Sorry, something went wrong. Please, try after sometime."
                ];
            }
        } catch (\Exception $error) {
            $this->aeResponse = [
                "bfs_responseCode" => "-1",
                "bfs_responseDesc" => "Sorry, something went wrong. Please, try after sometime."
            ];
        }

        $this->isLoadingNotifier = false;
    }

    public function verifyOTP(){
        $this->validate([
            'otp_inputs' => 'required|array|min:6',
        ]);
        $this->isLoadingNotifier = true;
        $this->otp = implode('', $this->otp_inputs);
        $this->setRequestType('DR');
        $this->makePaymentDR();
    }

    private function makePaymentDR() {

        $query = ' query {
            makeDrRequest(input: {
                txn_id:  "' .$this->arResponse['bfs_bfsTxnId']. '"
                remitter_otp:  "' .$this->otp. '"
            }) {
                data
                error {
                    code
                    message
                }
            }
        }';

        $response = (new RmaPaymentService)->makePaymentRequest($query);
        // dd(json_decode($response->getBody(),true));
        try {
            $responseBody = json_decode($response->getBody(), true);
            $jsonData = $responseBody['data']['makeDrRequest'];
        
            if ($jsonData !== null) {
                parse_str($jsonData['data'], $this->drResponse);
        
                // Check if transaction data is present and valid
                if (isset($this->drResponse['bfs_debitAuthCode']) && $this->drResponse['bfs_debitAuthCode'] === '00') {
                    // Process successful payment response
                    // Here you handle successful transaction logic
                        $emailDetails = [
                            'name' => $this->fullname,
                            'product' => $this->productName,
                            'price' => $this->price,
                            'subject' => 'Payment Successful',
                            'email_id' => $this->email,
                            'payment_type' => 'rma',
                            'random_text' => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10) 
                        ];
                        Payment::create($emailDetails);
                        send_payment($this->email, 'Payment Successful', $emailDetails);
                } else {
                    // Handle failed OTP verification
                    $this->drResponse = [
                        "bfs_responseCode" => "-2",
                        "bfs_responseDesc" => "OTP verification failed. Please try again."
                    ];
                }
            } else {
                // Handle case where $jsonData is null or data is missing
                $this->drResponse = [
                    "bfs_responseCode" => "-1",
                    "bfs_responseDesc" => "An error occurred. Please try again later."
                ];
            }
        } catch (\Exception $error) {
            // Handle exception
            $this->drResponse = [
                "bfs_responseCode" => "-1",
                "bfs_responseDesc" => "An error occurred. Please try again later."
            ];
        }
            // dd($this->drResponse);

        $this->isLoadingNotifier = false;
    }

    public function verifyCode()
    {
        $this->validate([
            'code' => 'required|string',
        ]);
        try {
            $payment = Payment::where('random_text', $this->code)->first();
            if ($payment) {
                if ($payment->payment_type === 'rma' && !$payment->is_verified) {
                    $payment->update(['is_verified' => true]);
                    session(['verified' => true, 'availability_date' => '2024-07-09']);
                    return redirect('/video');
                } else {
                    $this->addError('code', 'Verification code is already used or invalid.');
                }
            } else {
                $this->addError('code', 'Verification code is incorrect.');
            }
        } catch (\Exception $e) {
            $this->addError('code', 'Verification code could not be verified.');
        }
    }


    public function getResponseDescription($responseCode) {
        switch ($responseCode) {
            case '00':
                return 'Approved.';
            case '03':
                return 'Invalid Beneficiary.';
            case '05':
                return 'Beneficiary Account Closed.';
            case '12':
                return 'Invalid Transaction.';
            case '13':
                return 'Invalid Amount.';
            case '14':
                return 'Invalid Remitter Account.';
            case '20':
                return 'Invalid Response.';
            case '30':
                return 'Transaction Not Supported Or Format Error.';
            case '45':
                return 'Duplicate Beneficiary Order Number.';
            case '47':
                return 'Invalid Currency.';
            case '48':
                return 'Transaction Limit Exceeded.';
            case '51':
                return 'Insufficient Funds.';
            case '53':
                return 'No Savings Account.';
            case '57':
                return 'Transaction Not Permitted.';
            case '61':
                return 'Withdrawal Limit Exceeded.';
            case '65':
                return 'Withdrawal Frequency Exceeded.';
            case '76':
                return 'Transaction Not Found.';
            case '78':
                return 'Decryption Failed.';
            case '80':
                return 'Buyer Cancel Transaction.';
            case '84':
                return 'Invalid Transaction Type.';
            case '85':
                return 'Internal Error At Bank System.';
            case 'BC':
                return 'Transaction Cancelled By Customer.';
            case 'FE':
                return 'Internal Error.';
            case 'OA':
                return 'Session Timeout at BFS Secure Entry Page.';
            case 'OE':
                return 'Transaction Rejected As Not In Operating Hours.';
            case 'OF':
                return 'Transaction Timeout.';
            case 'SB':
                return 'Invalid Beneficiary Bank Code.';
            case 'XE':
                return 'Invalid Message.';
            case 'XT':
                return 'Invalid Transaction Type.';
            default:
                return 'Sorry, something went wrong. Please, try again after sometime.';
        }
    }
}
