<?php
namespace Yaw\AppBundle\Core\Service\Microbilt;
/**
 * Created by JetBrains PhpStorm.
 * User: yurijmalcev
 * Email: yuriy.m@visiontechglobal.com
 * Date: 27.02.13
 * Time: 15:25
 */
class MbClient extends \SoapClient
{
    private static $classmap = array(
        'MsgRqHdr_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\MsgRqHdr',
        'RequestType' => 'RequestType',
        'PersonInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PersonInfo',
        'Aggregate' => 'Aggregate',
        'EmploymentHistory_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\EmploymentHistory',
        'OrgInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\OrgInfo',
        'IndustId_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\IndustId',
        'CodeDescription_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CodeDescription',
        'ContactInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\ContactInfo',
        'PhoneNum_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PhoneNum',
        'Boolean' => 'Boolean',
        'PostAddr_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PostAddr',
        'GEOCode_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\GEOCode',
        'Message_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Message',
        'ValidationInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\ValidationInfo',
        'TINInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\TINInfo',
        'DateRange_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\DateRange',
        'OtherTaxId_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\OtherTaxId',
        'OrgId_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\OrgId',
        'CharterInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CharterInfo',
        'CurrencyAmount' => 'CurrencyAmount',
        'Option_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Option',
        'DriversLicense_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\DriversLicense',
        'SpouseInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\SpouseInfo',
        'PersonName_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PersonName',
        'SchoolInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\SchoolInfo',
        'PhysicalCharacteristics_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PhysicalCharacteristics',
        'Summary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Summary',
        'CompAmt_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CompAmt',
        'Liability_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Liability',
        'Rating_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Rating',
        'PaymentInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PaymentInfo',
        'CategoryInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CategoryInfo',
        'ElementsInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\ElementsInfo',
        'AmtItems_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\AmtItems',
        'PublicRecord_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PublicRecord',
        'CourtInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CourtInfo',
        'Release_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Release',
        'SentenceLength_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\SentenceLength',
        'SubjectConfirmation_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\SubjectConfirmation',
        'Accident_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Accident',
        'AccidentLocation_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\AccidentLocation',
        'AccidentTime_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\AccidentTime',
        'Conditions_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Conditions',
        'Investigation_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Investigation',
        'AccidentStatistics_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\AccidentStatistics',
        'Violation_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Violation',
        'DecisionTable_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\DecisionTable',
        'DecisionTableSummary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\DecisionTableSummary',
        'DecisionTableDetails_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\DecisionTableDetails',
        'BankStatement_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\BankStatement',
        'BankAccount_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\BankAccount',
        'ApplicantData_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\ApplicantData',
        'ChargeOff_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\ChargeOff',
        'PmtAgreement_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PmtAgreement',
        'OFAC_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\OFAC',
        'AddressInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\AddressInfo',
        'PhoneInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PhoneInfo',
        'DataIndicators_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\DataIndicators',
        'LoanParams_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\LoanParams',
        'LoanInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\LoanInfo',
        'PathInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PathInfo',
        'VariableInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\VariableInfo',
        'Decision_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Decision',
        'DecisionInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\DecisionInfo',
        'VictimInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\VictimInfo',
        'TransactionFee_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\TransactionFee',
        'UCC_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\UCC',
        'InternetDomain_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\InternetDomain',
        'Relative_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Relative',
        'OffenderRef_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\OffenderRef',
        'SexualOffense_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\SexualOffense',
        'CriminalCase_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CriminalCase',
        'Charge_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Charge',
        'PrisonSentenceInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PrisonSentenceInfo',
        'ParoleSentenceInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\ParoleSentenceInfo',
        'RegistrationDetails_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\RegistrationDetails',
        'VehicleInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\VehicleInfo',
        'AutomobileInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\AutomobileInfo',
        'AutomobileExtras_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\AutomobileExtras',
        'LienHolderInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\LienHolderInfo',
        'CommercialDates_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialDates',
        'VesselInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\VesselInfo',
        'AircraftInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\AircraftInfo',
        'CivilCourt_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CivilCourt',
        'Parties_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Parties',
        'Event_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Event',
        'Neighborhood_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Neighborhood',
        'NeighborhoodResident_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\NeighborhoodResident',
        'VoterRegistration_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\VoterRegistration',
        'HuntingFishingLicense_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\HuntingFishingLicense',
        'WeaponPermit_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\WeaponPermit',
        'Incarceration_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Incarceration',
        'Fraud_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Fraud',
        'FraudValidations_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\FraudValidations',
        'Ineligibility_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Ineligibility',
        'Attachment_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Attachment',
        'EvictionsCase_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\EvictionsCase',
        'ClosureInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\ClosureInfo',
        'Inquiry_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Inquiry',
        'BusinessInquiry_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\BusinessInquiry',
        'QFInformation_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\QFInformation',
        'Score_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Score',
        'QFProdOffer_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\QFProdOffer',
        'LiabilitySummary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\LiabilitySummary',
        'AuthConfig_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\AuthConfig',
        'QuestionConfig_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\QuestionConfig',
        'QuestionsAnswers_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\QuestionsAnswers',
        'Answers_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Answers',
        'SubQuestions_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\SubQuestions',
        'InvalidAnswers_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\InvalidAnswers',
        'AccountingInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\AccountingInfo',
        'PeriodInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\PeriodInfo',
        'InternationalCourtInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\InternationalCourtInfo',
        'IntlCourtDetailsInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\IntlCourtDetailsInfo',
        'IntlCourtPeriodInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\IntlCourtPeriodInfo',
        'IntlCourtElementsInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\IntlCourtElementsInfo',
        'CompanyHistory_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CompanyHistory',
        'CorporateCreditRating_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CorporateCreditRating',
        'CreditRating_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CreditRating',
        'EconomicInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\EconomicInfo',
        'DebtSummary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\DebtSummary',
        'FinancialSummary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\FinancialSummary',
        'InformationSummary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\InformationSummary',
        'InformationDetail_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\InformationDetail',
        'KeyIndustrySectorTrends_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\KeyIndustrySectorTrends',
        'LegalFormsInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\LegalFormsInfo',
        'RegisteredCharge_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\RegisteredCharge',
        'RegisteredChargesDetails_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\RegisteredChargesDetails',
        'CommercialAmounts_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialAmounts',
        'RegisteredChargesSummary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\RegisteredChargesSummary',
        'RegisteredChargesInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\RegisteredChargesInfo',
        'ShareCapitalSummary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\ShareCapitalSummary',
        'ShareCapital_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\ShareCapital',
        'StockExchangeInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\StockExchangeInfo',
        'TradeCountries_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\TradeCountries',
        'TradeReferenceSummary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\TradeReferenceSummary',
        'TradeReferenceDetailInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\TradeReferenceDetailInfo',
        'TradeReferenceElementInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\TradeReferenceElementInfo',
        'ExchangeRateInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\ExchangeRateInfo',
        'DocumentInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\DocumentInfo',
        'CRASummary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CRASummary',
        'EBAddOns_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\EBAddOns',
        'CommercialExecutiveSummary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialExecutiveSummary',
        'CommercialCollectionInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialCollectionInfo',
        'CommercialPmtInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialPmtInfo',
        'CommercialPmtTotals_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialPmtTotals',
        'CommercialPmtTrends_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialPmtTrends',
        'CommercialPublicRecords_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialPublicRecords',
        'CommercialUCCSummary_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialUCCSummary',
        'SummaryCountTimeFrame_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\SummaryCountTimeFrame',
        'OfficersDirectors_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\OfficersDirectors',
        'CommercialUCC_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialUCC',
        'CollateralInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CollateralInfo',
        'OriginalUCCInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\OriginalUCCInfo',
        'CommercialEntityInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialEntityInfo',
        'CommercialLeasingInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialLeasingInfo',
        'CommercialFilings_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\CommercialFilings',
        'Associate_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Associate',
        'EvictionsDates_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\EvictionsDates',
        'FilingsInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\FilingsInfo',
        'LoanRequestInfo_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\LoanRequestInfo',
        'Report_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Report',
        'MsgRsHdr_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\MsgRsHdr',
        'Status_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Status',
        'Severity_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\Severity',
        'AdditionalStatus_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\AdditionalStatus',
        'MBPRBCFESRq_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\MBPRBCFESRq',
        'MBPRBCFESRs_Type' => 'Yaw\AppBundle\Core\Service\Microbilt\Type\MBPRBCFESRs',
        'Subject' => 'Yaw\AppBundle\Core\Service\Microbilt\Subject',
        'GetData' => 'Yaw\AppBundle\Core\Service\Microbilt\GetData',
        'GetDataResponse' => 'Yaw\AppBundle\Core\Service\Microbilt\GetDataResponse',
        'GetReport' => 'Yaw\AppBundle\Core\Service\Microbilt\GetReport',
        'GetReportResponse' => 'Yaw\AppBundle\Core\Service\Microbilt\GetReportResponse',
    );

    public function __construct($wsdl = "https://sdkstage.microbilt.com/WebServices/PRBC/BPS_FES.svc?wsdl", $options = array()) {
        foreach(self::$classmap as $key => $value) {
            if(!isset($options['classmap'][$key])) {
                $options['classmap'][$key] = $value;
            }
        }
        parent::__construct($wsdl, $options);
    }

    /**
     *
     *
     * @param GetData $parameters
     * @return GetDataResponse
     */
    public function GetData(GetData $parameters) {
        return $this->__soapCall('GetData', array($parameters),
            array(
                'uri' => 'http://tempuri.org/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param GetReport $parameters
     * @return GetReportResponse
     */
    public function GetReport(GetReport $parameters) {
        return $this->__soapCall('GetReport', array($parameters),
            array(
                'uri' => 'http://tempuri.org/',
                'soapaction' => ''
            )
        );
    }
}