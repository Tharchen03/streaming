<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Services\RmaPaymentService;

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
    #[Validate('required')]
    public $bfsRemitterOtp;
    public $arResponse = null;
    public $aeResponse = null;
    public $drResponse = null;
    private $price;
    private $productName;
    public $isLoadingNotifier = false;

    public function mount(){
        $this->productName = "Movie";
        $this->price = 10;
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

    private function setDRDetails($otp) {
        $this->bfsRemitterOtp = $otp;
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
        $paymentService = new RmaPaymentService;
        $response = $paymentService->makePaymentRequest($query);
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
        $this->isLoadingNotifier = true;
        $this->setRequestType('AE');
        $this->makePaymentAE();
    }

    public function cancelPaymentRequest(){
       return  redirect()->route('home');
    }

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
        $paymentService = new RmaPaymentService;

        $response = $paymentService->makePaymentRequest($query);
        // dd(json_decode($response->getBody(),true));
        try {
            $jsonData = $response['data']['makeAeRequest'];
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

    private function makePaymentDR() {
        $this->isLoadingNotifier = true;

        $query = <<<QUERY
        query {
            makeDrRequest(input: {
               txn_id:  "' .$this->bfsTxnId. '"
                remitter_otp:  "' .$this->bfsRemitterOtp. '"
            }) {
                data
                error {
                    code
                    message
                }
            }
        }
        QUERY;

        $response = $this->paymentService->makePaymentRequest($query);
        try {
            $jsonData = $response['data']['makeDrRequest'];
            if ($jsonData !== null && $jsonData['data'] !== null) {
                parse_str($jsonData['data'], $this->drResponse);
            } else {
                $this->drResponse = [
                    "bfs_responseCode" => "-2",
                    "bfs_responseDesc" => "Sorry, something went wrong. Please, try after sometime."
                ];
            }
        } catch (\Exception $error) {
            $this->drResponse = [
                "bfs_responseCode" => "-1",
                "bfs_responseDesc" => "Sorry, something went wrong. Please, try after sometime."
            ];
        }
        $this->isLoadingNotifier = false;
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
