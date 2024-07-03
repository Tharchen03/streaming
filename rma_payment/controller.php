<?php
require 'services.php';

class PaymentController {
    private $paymentService;
    private $bfsMsgType;
    private $bfsTxnId;
    private $bfsRemitterAccNo;
    private $bfsRemitterBankId;
    private $bfsRemitterOtp;
    private $arResponse = false;
    private $aeResponse = false;
    private $drResponse = false;
    private $price;
    private $productName;
    private $isLoadingNotifier = false;

    public function __construct($productName, $price) {
        $this->productName = $productName;
        $this->price = $price;
        $this->paymentService = new PaymentService();
        $this->setRequestType('AR');
        $this->makePaymentAR();
    }

    private function setRequestType($requestType) {
        $this->bfsMsgType = $requestType;
    }

    private function setAEDetails($transactionId, $bank, $accountNo) {
        $this->bfsTxnId = $transactionId;
        $this->bfsRemitterAccNo = $accountNo;
        $this->bfsRemitterBankId = $bank;
    }

    private function setDRDetails($otp) {
        $this->bfsRemitterOtp = $otp;
    }

    private function makePaymentAR() {
        $this->isLoadingNotifier = true;
        $bfsTxnAmount = $this->price;
        $package = $this->productName;
        $query = <<<QUERY
        query {
            makeArRequest(input: {
                remitter_email: ""
                amount: "{$bfsTxnAmount}"
                package: "{$package}"
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
            $jsonData = $response['data']['makeArRequest'];
            if ($jsonData['data'] !== null) {
                parse_str($jsonData['data'], $this->arResponse);
            } else {
                $this->arResponse = [
                    "bfs_responseCode" => "-2",
                    "bfs_responseDesc" => "Sorry, something went wrong. Please, try after sometime."
                ];
            }
        } catch (Exception $error) {
            $this->arResponse = [
                "bfs_responseCode" => "-1",
                "bfs_responseDesc" => "Sorry, something went wrong. Please, try after sometime."
            ];
        }
        $this->isLoadingNotifier = false;
    }

    private function makePaymentAE() {

        $this->isLoadingNotifier = true;
        $query = <<<QUERY
        query {
            makeAeRequest(input: {
                txn_id: {"$this->bfsTxnId"}
                remitter_bank_id: {"$this->bfsRemitterBankId"}
                remitter_acc_no: {"$this->bfsRemitterAccNo"}
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
            $jsonData = $response['data']['makeAeRequest'];
            if ($jsonData['data'] !== null) {
                parse_str($jsonData['data'], $this->aeResponse);
            } else {
                $this->aeResponse = [
                    "bfs_responseCode" => "-2",
                    "bfs_responseDesc" => "Sorry, something went wrong. Please, try after sometime."
                ];
            }
        } catch (Exception $error) {
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
               txn_id: {"$this->bfsTxnId"}
                remitter_otp: {"$this->bfsRemitterOtp"}
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
        } catch (Exception $error) {
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