<?php

class MsgRqHdr_Type {
    public $MemberId; // string
    public $MemberPwd; // string
    public $RequestType; // RequestType
    public $ReasonCode; // string
    public $GLBPurpose; // string
    public $DLPurpose; // string
    public $RefNum; // string
    public $UserName; // string
    public $Timeout; // long
    public $FrozenFilePIN; // string
    public $OutputFormat; // string
}

class RequestType {
}

class PersonInfo_Type {
    public $PersonName; // PersonName_Type
    public $ContactInfo; // ContactInfo_Type
    public $TINInfo; // TINInfo_Type
    public $BirthDt; // date
    public $BirthState; // string
    public $BirthCountry; // string
    public $DeathDt; // date
    public $DriversLicense; // DriversLicense_Type
    public $MothersMaidenName; // string
    public $SpouseInfo; // SpouseInfo_Type
    public $EmploymentHistory; // EmploymentHistory_Type
    public $SchoolInfo; // SchoolInfo_Type
    public $PhysicalCharacteristics; // PhysicalCharacteristics_Type
    public $Citizenship; // string
    public $LanguageSpoken; // string
    public $Message; // Message_Type
    public $Quality; // string
    public $BirthCity; // string
    public $Nationality; // string
    public $Affiliation; // string
    public $ValidationInfo; // ValidationInfo_Type
    public $RecordID; // string
    public $MilitaryIdInfo; // MilitaryIdInfo_Type
    public $PassportInfo; // PassportInfo_Type
}

class Aggregate {
    public $Source; // string
    public $EffDt; // date
}

class Summary_Type {
    public $BalanceAmt; // CompAmt_Type
    public $ClosedAccts; // long
    public $CollCount; // long
    public $CollTransferred; // long
    public $InqCount; // long
    public $EmpInqCount; // long
    public $HighCreditAmt; // CompAmt_Type
    public $InstAccts; // long
    public $MortgageAccts; // long
    public $OpenAccts; // long
    public $PaidAccts; // long
    public $RevAccts; // long
    public $RevAvailPercent; // long
    public $PublicRecs; // long
    public $OtherTrades; // long
    public $NowDelinqDerog; // long
    public $WasDelinqDerog; // long
    public $MostRecentTradeDt; // date
    public $OldestTradeDt; // date
    public $PastDueBalAmt; // CompAmt_Type
    public $PaymentAmt; // CompAmt_Type
    public $RealEstateBalAmt; // CompAmt_Type
    public $RealEstatePmtAmt; // CompAmt_Type
    public $TotalCreditLimitAmt; // CompAmt_Type
    public $DisputedTrades; // long
    public $TotalTrades; // long
    public $CurrentTrades; // long
    public $LateCount30; // long
    public $LateCount60; // long
    public $LateCount90; // long
    public $InqWithin6Months; // long
    public $Message; // Message_Type
    public $PastDueCount; // long
    public $UnratedCount; // long
    public $AverageMonthlyPmtAmt; // CurrencyAmount
}

class CompAmt_Type {
    public $TotalAmt; // CurrencyAmount
    public $InstAmt; // CurrencyAmount
    public $RevAmt; // CurrencyAmount
    public $ClosedWithBalAmt; // CurrencyAmount
}

class CurrencyAmount {
    public $Amt; // decimal
    public $CurCode; // string
}

class Message_Type {
    public $MsgClass; // string
    public $MsgCode; // string
    public $Text; // string
}

class Liability_Type {
    public $AcctId; // string
    public $OrgInfo; // OrgInfo_Type
    public $ReviewReq; // Boolean
    public $OpenedDt; // date
    public $Closed; // Boolean
    public $ClosedDt; // date
    public $PaidDt; // date
    public $ReportedDt; // date
    public $OwnershipType; // string
    public $AcctStatus; // string
    public $StatusDt; // date
    public $AcctType; // string
    public $BalanceDt; // date
    public $CreditLimitAmt; // CurrencyAmount
    public $BalloonPmtAmt; // CurrencyAmount
    public $ChargeOffAmt; // CurrencyAmount
    public $LoanType; // string
    public $CollateralDesc; // string
    public $OrigLoanAmt; // CurrencyAmount
    public $DisputeInd; // Boolean
    public $DerogInd; // Boolean
    public $CurrentRating; // Rating_Type
    public $MOP; // string
    public $LastActivityDt; // date
    public $HighBalanceAmt; // CurrencyAmount
    public $HighCreditAmt; // CompAmt_Type
    public $LateCount30; // long
    public $LateCount60; // long
    public $LateCount90; // long
    public $LateCount120; // long
    public $PmtPattern; // string
    public $PastDueAmt; // CurrencyAmount
    public $UnpaidBalanceAmt; // CurrencyAmount
    public $ActualPmtAmt; // CurrencyAmount
    public $EstimatedPmtAmt; // CurrencyAmount
    public $ScheduledPmtAmt; // CurrencyAmount
    public $MonthsReviewed; // long
    public $PmtStatus; // string
    public $Terms; // string
    public $MaxDelinqRating; // Rating_Type
    public $MostRecentRating; // Rating_Type
    public $DueDate; // date
    public $PmtFreq; // string
    public $Message; // Message_Type
    public $PaymentInfo; // PaymentInfo_Type
}

class OrgInfo_Type {
    public $IndustId; // IndustId_Type
    public $Name; // string
    public $LegalName; // string
    public $ContactInfo; // ContactInfo_Type
    public $DeptDivGrp; // string
    public $TINInfo; // TINInfo_Type
    public $EstablishDt; // date
    public $NumEmployees; // long
    public $OrgId; // OrgId_Type
    public $CorpType; // CodeDescription_Type
    public $CorpStatus; // string
    public $CorpStatusDt; // date
    public $Message; // Message_Type
    public $IncorporationDt; // date
    public $CharterInfo; // CharterInfo_Type
    public $AgentInfo; // PersonInfo_Type
    public $MergedName; // string
    public $DBAName; // string
    public $PriorName; // string
    public $OrigDtFiled; // date
    public $RecentFilingDt; // date
    public $BusType; // string
    public $ActiveStatusInd; // Boolean
    public $BusStatusDesc; // string
    public $ForProfitInd; // Boolean
    public $OwnerRegistrantInfo; // PersonInfo_Type
    public $OrgType; // string
    public $RecordID; // string
}

class IndustId_Type {
    public $Org; // string
    public $IndustNum; // string
    public $IndustType; // CodeDescription_Type
}

class CodeDescription_Type {
    public $Code; // string
    public $Description; // string
}

class ContactInfo_Type {
    public $ContactPref; // string
    public $PhoneNum; // PhoneNum_Type
    public $ContactName; // string
    public $EmailAddr; // string
    public $URL; // string
    public $PostAddr; // PostAddr_Type
    public $Message; // Message_Type
    public $ContactType; // string
    public $ValidationInfo; // ValidationInfo_Type
}

class PhoneNum_Type {
    public $PhoneType; // string
    public $Phone; // string
    public $Published; // Boolean
}

class Boolean {
}

class PostAddr_Type {
    public $PreDirection; // string
    public $Addr2; // string
    public $PostDirection; // string
    public $Addr3; // string
    public $StreetType; // string
    public $Addr4; // string
    public $StreetName; // string
    public $Apt; // string
    public $StreetNum; // string
    public $Addr1; // string
    public $City; // string
    public $StateProv; // string
    public $PostalCode; // string
    public $County; // string
    public $Country; // string
    public $AddrType; // string
    public $StartDt; // date
    public $EndDt; // date
    public $OwnershipCode; // string
    public $ReportedDt; // date
    public $AddrSource; // string
    public $GEOCode; // GEOCode_Type
    public $AddrCreatedDt; // date
    public $LengthOfResidence; // string
    public $DropPointInd; // string
    public $DwellingUnitSize; // string
}

class GEOCode_Type {
    public $MSACode4; // string
    public $MSACode5; // string
    public $StateCode; // string
    public $CountyCode; // string
    public $CensusTrackCode; // string
    public $BlockCode; // string
    public $Latitude; // decimal
    public $Longitude; // decimal
    public $GEOCreatedDt; // date
}

class ValidationInfo_Type {
    public $NameValidation; // Message_Type
    public $SSNValidation; // Message_Type
    public $DOBValidation; // Message_Type
    public $DLValidation; // Message_Type
    public $DeceasedValidation; // Message_Type
    public $AddressValidation; // Message_Type
    public $PhoneValidation; // Message_Type
}

class TINInfo_Type {
    public $TINType; // string
    public $TaxId; // string
    public $CertCode = null; // string
    public $IssuedDt = null; // date
    public $IssuedState = null; // string
    public $DateRange = null; // DateRange_Type
    public $Country = null; // string
    public $OtherTaxId = null; // OtherTaxId_Type
}

class DateRange_Type {
    public $StartDt; // date
    public $EndDt; // date
}

class OtherTaxId_Type {
    public $TINType; // string
    public $AltTaxId; // string
}

class OrgId_Type {
    public $KOB; // string
    public $Description; // string
    public $SubscriberNum; // string
    public $BurMarket; // string
    public $BurSubMarket; // string
    public $CorpID; // string
}

class CharterInfo_Type {
    public $CharterNum; // string
    public $CharterTermYears; // long
    public $CharterTermDt; // date
}

class Rating_Type {
    public $Code; // string
    public $RatingType; // string
    public $RatingAmt; // CurrencyAmount
    public $RatingDt; // date
}

class PaymentInfo_Type {
    public $MsgClass; // string
    public $CategoryInfo; // CategoryInfo_Type
    public $PaymentElementsInfo; // ElementsInfo_Type
    public $Message; // Message_Type
}

class CategoryInfo_Type {
    public $MsgClass; // string
    public $CategoryIndicator; // long
    public $CategoryDt; // date
    public $Message; // Message_Type
}

class ElementsInfo_Type {
    public $MsgClass; // string
    public $AccountingAmtItems; // AmtItems_Type
}

class AmtItems_Type {
    public $Format; // string
    public $Priority; // string
    public $ElementAmt; // CurrencyAmount
    public $PercentageRatio; // decimal
    public $Message; // Message_Type
}

class PublicRecord_Type {
    public $CaseId; // string
    public $PRType; // string
    public $OrgInfo; // OrgInfo_Type
    public $ReviewReq; // Boolean
    public $OwnershipType; // string
    public $AttorneyName; // string
    public $BankruptcyAssetsAmt; // CurrencyAmount
    public $BankruptcyLiabilitiesAmt; // CurrencyAmount
    public $BankruptcyType; // string
    public $CourtName; // string
    public $CourtNum; // string
    public $DisputeInd; // Boolean
    public $DerogInd; // Boolean
    public $FilingDt; // date
    public $DefendantName; // string
    public $DispositionDt; // date
    public $DispositionType; // string
    public $LegalObligationAmt; // CurrencyAmount
    public $ManualUpdInd; // Boolean
    public $MaturityDt; // date
    public $PaidDt; // date
    public $PmtFreq; // string
    public $ReportedDt; // date
    public $SettledDt; // date
    public $VerifiedDt; // date
    public $LastActivityDt; // date
    public $StatusDt; // date
    public $Plaintiff; // string
    public $VoluntaryInd; // Boolean
    public $PRStatus; // string
    public $BalanceDt; // date
    public $ClaimAmt; // CurrencyAmount
    public $RentPmtAmt; // CurrencyAmount
    public $JudgeTrustee; // string
    public $DismissedDt; // date
    public $DischargedDt; // date
    public $CourtInfo; // CourtInfo_Type
    public $Message; // Message_Type
    public $FilingType; // string
    public $FilerType; // string
    public $FilingLocation; // string
    public $OrigDtFiled; // date
    public $ClosedDt; // date
    public $ReOpenedDt; // date
    public $ConvertedDt; // date
    public $Chapter; // string
    public $OrigChapter; // string
    public $FilingStatus; // string
    public $ClaimsDeadlineDt; // date
    public $ComplaintDeadlineDt; // date
    public $TransferredDt; // date
    public $WithdrawnDt; // date
    public $ClaimDt; // date
    public $ObjectionDt; // date
    public $Entity; // string
    public $NoticeType; // string
    public $Division; // string
    public $CaseNum2; // string
    public $OrigDept; // string
    public $OrigCase; // string
    public $OrigBook; // string
    public $OrigPage; // string
    public $Sch341DtTime; // string
    public $UnpaidBalanceAmt; // CurrencyAmount
    public $OriginalAmt; // CurrencyAmount
}

class CourtInfo_Type {
    public $CourtType; // string
    public $CourtCity; // string
    public $CourtState; // string
    public $BookPage; // string
    public $ExemptAmt; // CurrencyAmount
    public $Message; // Message_Type
    public $CourtJurisdiction; // string
    public $CourtNum; // string
    public $CourtName; // string
    public $CourtCaseId; // string
    public $CourtCostsAmt; // CurrencyAmount
    public $DispositionDt; // date
    public $DispositionType; // string
    public $Fine; // string
    public $RiskLevel; // CodeDescription_Type
    public $Plea; // string
    public $Statute; // string
    public $SuspendedFine; // string
    public $Jail; // string
    public $Probation; // Release_Type
    public $Suspended; // string
}

class Release_Type {
    public $StartDt; // date
    public $Agency; // OrgInfo_Type
    public $SentenceLength; // SentenceLength_Type
    public $ScheduledEndDt; // date
    public $ActualEndDt; // date
    public $Message; // Message_Type
}

class SentenceLength_Type {
    public $Years; // long
    public $Months; // long
    public $Days; // long
}

class SubjectConfirmation_Type {
    public $ByName; // Boolean
    public $ByFamilyName; // Boolean
    public $ByGivenName; // Boolean
    public $ByPrefGivenName; // Boolean
    public $ByMiddleName; // Boolean
    public $ByDOB; // Boolean
    public $ByGovernmentId; // Boolean
    public $ByOtherId; // Boolean
    public $BySex; // Boolean
    public $Message; // Message_Type
}

class Accident_Type {
    public $AccidentDt; // date
    public $AccidentLocation; // AccidentLocation_Type
    public $Location; // PostAddr_Type
    public $Damage; // string
    public $Agency; // OrgInfo_Type
    public $FilingDt; // date
    public $TypeFRCase; // string
    public $Action; // string
    public $AccidentTime; // AccidentTime_Type
    public $RoadType; // string
    public $NumOfLanes; // string
    public $SkidResistance; // string
    public $FrictionCoarse; // string
    public $AverageDailyTraffic; // string
    public $AccidentSeverity; // string
    public $Conditions; // Conditions_Type
    public $Investigation; // Investigation_Type
    public $AccidentStatistics; // AccidentStatistics_Type
    public $PersonInfo; // PersonInfo_Type
    public $Message; // Message_Type
}

class AccidentLocation_Type {
    public $StateRoadAccident; // string
    public $FootCityTown; // string
    public $MilesCityTown; // string
    public $DirectionCityTown; // string
    public $AtNodeNum; // string
    public $FootMilesNode; // string
    public $FromNodeNum; // string
    public $NextNodeRoadway; // string
    public $StateRoadHighwayName; // string
    public $AtIntersectOf; // string
    public $FootMilesFromIntersect; // string
    public $FootMiles; // string
    public $IntersectDirectionOf; // string
    public $OfIntersectOf; // string
    public $CodeableNoncodeable; // string
    public $TypeFacility; // string
    public $SiteLocation; // string
    public $DistrictIndex; // string
    public $SectionNum; // string
    public $NodeNum; // string
    public $DistanceFromNode; // string
    public $DirectionFromNode; // string
    public $StateRoadNum; // string
    public $USRoadNum; // string
    public $Milepost; // string
    public $HighwayLocation; // string
    public $Subsection; // string
    public $SystemType; // string
    public $Travelway; // string
    public $NodeType; // string
    public $FixtureType; // string
    public $SideOfRoad; // string
    public $LaneId; // string
}

class AccidentTime_Type {
    public $DayOfWeek; // string
    public $HourOfAccident; // string
    public $MinuteOfAccident; // string
    public $HourOffNotified; // string
    public $MinuteOffNotified; // string
    public $HourOffArrived; // string
    public $MinuteOffArrived; // string
}

class Conditions_Type {
    public $LocationType; // string
    public $Population; // string
    public $RuralUrban; // string
    public $SiteLocation; // string
    public $FirstHarmfulEvent; // string
    public $SecondHarmfulEvent; // string
    public $OnOffRoadway; // string
    public $LightCondition; // string
    public $Weather; // string
    public $RoadSurfaceType; // string
    public $ShoulderType; // string
    public $RoadSurfaceCondition; // string
    public $FirstContributingCause; // string
    public $SecondContributingCause; // string
    public $FirstContributingEnvironment; // string
    public $SecondContributingEnvironment; // string
    public $FirstTrafficControl; // string
    public $SecondTrafficControl; // string
    public $TrafficwayChar; // string
    public $NumOfLanes; // string
    public $DividedUndivided; // string
    public $RoadSystemId; // string
    public $InvestigationAgent; // string
    public $InjurySeverity; // string
    public $DamageSeverity; // string
    public $Insurance; // string
    public $AccidentFault; // string
    public $AlcoholDrug; // string
}

class Investigation_Type {
    public $AgentReportNum; // string
    public $AgentName; // string
    public $AgentRank; // string
    public $AgentIdBadgeNum; // string
    public $AgentDepartmentName; // string
    public $InvestComplete; // string
    public $SearchDt; // date
    public $PhotosTaken; // string
    public $PhotosTakenWhom; // string
    public $FirstAidName; // string
    public $FirstAidPersonType; // string
    public $InjuredTakenTo; // string
    public $InjuredTakenBy; // string
    public $TypeDriverAccident; // string
    public $HourOfEMSNotified; // string
    public $MinuteOfEMSNotified; // string
    public $HourOfEMSArrived; // string
    public $MinuteOfEMSArrived; // string
}

class AccidentStatistics_Type {
    public $TotalTarDamage; // string
    public $TotalVehicleDamage; // string
    public $TotalPropertyDamage; // string
    public $TotalNumOfPersons; // string
    public $TotalNumOfDrivers; // string
    public $TotalNumOfVehicles; // string
    public $TotalNumOfFatalities; // string
    public $TotalNumOfNonTrafficFatal; // string
    public $TotalNumOfInjuries; // string
    public $TotalNumOfPedestrians; // string
    public $TotalNumOfPedalcyclists; // string
}

class Violation_Type {
    public $ViolationDt; // date
    public $ViolationType; // string
    public $ViolationCode; // string
    public $ViolationACDCode; // string
    public $Description; // string
    public $ConvictedDt; // date
    public $Points; // string
    public $Location; // PostAddr_Type
    public $Agency; // OrgInfo_Type
    public $CourtName; // string
    public $VehicleType; // string
    public $HazMat; // Boolean
    public $Message; // Message_Type
}

class DecisionTable_Type {
    public $DecisionTableSummary; // DecisionTableSummary_Type
    public $DecisionTableDetails; // DecisionTableDetails_Type
    public $Message; // Message_Type
}

class DecisionTableSummary_Type {
    public $RuleSetID; // string
    public $DecisionDescription; // string
    public $DecisionProduct; // CodeDescription_Type
}

class DecisionTableDetails_Type {
    public $Function; // string
    public $Result; // string
    public $Passed; // Boolean
}

class BankStatement_Type {
    public $StatementDt; // date
    public $NumberOfTransactions; // long
    public $NumberOfNSFs; // long
    public $BalanceAmt; // CompAmt_Type
    public $VerifiedDt; // date
    public $StatementBalAmt; // CurrencyAmount
}

class BankAccount_Type {
    public $OrgInfo; // OrgInfo_Type
    public $RoutingNumber; // string
    public $AccountNum; // string
    public $TypeOfBankAcct; // string
    public $OpenedDt; // date
    public $AcctStatus; // string
    public $OwnershipType; // string
    public $BankStatement; // BankStatement_Type
    public $Message; // Message_Type
}

class ApplicantData_Type {
    public $RentPmtAmt; // CurrencyAmount
    public $NumberOfCurrentLoans; // long
    public $PreviousCustomer; // Boolean
    public $PayrollGarnishment; // Boolean
    public $CurrentBankruptcy; // Boolean
    public $CurrentWriteOff; // Boolean
}

class ChargeOff_Type {
    public $OrgInfo; // OrgInfo_Type
    public $RecoveryType; // string
    public $RecoveryDt; // date
    public $PersonInfo; // PersonInfo_Type
    public $RefNum; // string
    public $PmtAgreement; // PmtAgreement_Type
}

class PmtAgreement_Type {
    public $AcctId; // string
    public $AgreementDt; // date
    public $TotalAmt; // CurrencyAmount
    public $InstAmt; // CurrencyAmount
    public $PmtTerms; // long
    public $PmtPattern; // string
    public $PmtFreq; // string
    public $Description; // string
    public $ChargeOffAmt; // CurrencyAmount
    public $BalanceAmt; // CompAmt_Type
    public $ValueAmt; // CurrencyAmount
    public $OpenedDt; // date
    public $ReportedDt; // date
    public $PaidDt; // date
    public $Message; // Message_Type
}

class OFAC_Type {
    public $PersonInfo; // PersonInfo_Type
    public $ResponseCode; // CodeDescription_Type
    public $ProblemCode; // CodeDescription_Type
    public $MatchCode; // CodeDescription_Type
    public $SourceSanction; // string
    public $IssueId; // string
    public $Value; // long
    public $FileName; // string
    public $FileDt; // date
    public $Message; // Message_Type
}

class AddressInfo_Type {
    public $PersonInfo; // PersonInfo_Type
    public $PostAddr; // PostAddr_Type
    public $Verified; // Boolean
    public $Shared; // Boolean
    public $PhoneInfo; // PhoneInfo_Type
}

class PhoneInfo_Type {
    public $PersonName; // PersonName_Type
    public $PhoneNum; // PhoneNum_Type
    public $Published; // Boolean
    public $PhoneTypeIndicators; // DataIndicators_Type
}

class PersonName_Type {
    public $LastName; // string
    public $FirstName; // string
    public $FullName; // string
    public $MiddleName; // string
    public $TitlePrefix; // string
    public $NameSuffix; // string
    public $Nickname; // string
    public $LegalName; // string
    public $MaidenName; // string
    public $OfficialTitle; // string
}

class DataIndicators_Type {
    public $IndName; // string
    public $IndValue; // Boolean
}

class LoanParams_Type {
    public $RequestedAmt; // CurrencyAmount
    public $FeeAmt; // CurrencyAmount
    public $DueDate; // date
    public $Renewal; // Boolean
    public $Rollover; // Boolean
    public $RolloverNumber; // long
    public $ConsecutiveLoanNumber; // long
    public $LastLoanEndDt; // date
    public $LoanAmountFlag; // string
    public $LoanDuration; // long
    public $GenericRequestField; // string
    public $DaysOpen; // long
    public $LoanType; // string
    public $AlternativeLoanAmt; // CurrencyAmount
    public $ApprovalAmt; // CurrencyAmount
    public $Name; // string
    public $Error; // string
    public $DebtToIncome; // string
    public $LoansRemaining; // long
    public $CoolOffDaysRemaining; // long
    public $CoolOffPeriodRemaining; // string
    public $DaysBeforeCoolingOffPeriod; // long
    public $DaysBefore90DayLimit; // long
    public $EligibleDt; // date
    public $StateProv; // string
    public $Message; // Message_Type
}

class LoanInfo_Type {
    public $OrgInfo; // OrgInfo_Type
    public $FilingDt; // date
    public $SecuredAmt; // decimal
    public $MaturityDt; // date
    public $LoanParams; // LoanParams_Type
}

class PathInfo_Type {
    public $Node; // string
    public $Name; // string
}

class VariableInfo_Type {
    public $Node; // string
    public $Name; // string
    public $VariableValue; // string
}

class Decision_Type {
    public $DecisionCode; // string
    public $ReturnValue; // CodeDescription_Type
    public $Text; // string
}

class DecisionInfo_Type {
    public $ProductType; // string
    public $ProductInfo; // CodeDescription_Type
    public $Decision; // Decision_Type
    public $VariableInfo; // VariableInfo_Type
    public $PathInfo; // PathInfo_Type
}

class VictimInfo_Type {
    public $VictimIsMinor; // Boolean
    public $VictimAge; // string
    public $VictimGender; // string
    public $VictimRelationship; // string
}

class TransactionFee_Type {
    public $BaseFee; // CurrencyAmount
    public $JurisdictionFee; // CurrencyAmount
    public $AdditionalFee; // CurrencyAmount
}

class UCC_Type {
    public $PersonInfo; // PersonInfo_Type
    public $FileDt; // date
    public $FilingState; // string
    public $FilingNum; // string
    public $OrigDtFiled; // date
    public $OrigNum; // string
    public $CollateralDesc; // string
    public $FilingCount; // string
    public $DocumentCount; // string
}

class InternetDomain_Type {
    public $DomainName; // string
    public $DtLastSeen; // date
    public $DtLastUpdated; // date
    public $DtExpires; // date
    public $DtCreated; // date
    public $DtDatabase; // date
    public $PersonInfo; // PersonInfo_Type
}

class Relative_Type {
    public $Probability; // string
    public $PersonInfo; // PersonInfo_Type
    public $Message; // Message_Type
}

class OffenderRef_Type {
    public $OffenderID; // string
    public $DOCNum; // string
    public $SORNum; // string
    public $StateIDNum; // string
    public $FBINum; // string
    public $NCICNum; // string
    public $FingerprintOnFile; // string
}

class SexualOffense_Type {
    public $PersonInfo; // PersonInfo_Type
    public $CriminalCase; // CriminalCase_Type
    public $RegistrationDetails; // RegistrationDetails_Type
    public $VehicleInfo; // VehicleInfo_Type
    public $OffenderRef; // OffenderRef_Type
}

class CriminalCase_Type {
    public $CaseId; // string
    public $ArrestingAgency; // OrgInfo_Type
    public $CourtName; // string
    public $CourtNum; // string
    public $CourtJurisdiction; // string
    public $FileDt; // date
    public $StartDt; // date
    public $EndDt; // date
    public $PersonInfo; // PersonInfo_Type
    public $Charge; // Charge_Type
    public $Message; // Message_Type
    public $PrisonSentenceInfo; // PrisonSentenceInfo_Type
    public $ParoleSentenceInfo; // ParoleSentenceInfo_Type
    public $AACaseId; // string
}

class Charge_Type {
    public $ChargeId; // string
    public $ChargeDesc; // string
    public $ChargeType; // string
    public $ChargeClass; // string
    public $ChargeDt; // date
    public $ArrestDt; // date
    public $OffenseDt; // date
    public $Plea; // string
    public $Sentence; // string
    public $SentenceDt; // date
    public $DispositionDt; // date
    public $DispositionType; // string
    public $ProbationStatus; // string
    public $DefendantName; // string
    public $Plaintiff; // string
    public $OriginationState; // string
    public $OriginationCounty; // string
    public $OffenderStatus; // string
    public $OffenderCategory; // string
    public $Judgment; // string
    public $RiskLevel; // CodeDescription_Type
    public $Message; // Message_Type
    public $AdjudicationWithheld; // string
    public $CaseId; // string
    public $Count; // string
    public $County; // string
    public $OffenseDesc; // string
    public $MaxTerm; // string
    public $MinTerm; // string
    public $NumOfCounts; // long
    public $AppealDt; // date
    public $Statute; // string
    public $ArrestType; // string
    public $FinalDesposition; // string
}

class PrisonSentenceInfo_Type {
    public $AdmittedDt; // date
    public $SentenceStatus; // string
    public $CustodyType; // string
    public $CustodyTypeChangeDt; // date
    public $GainTimeGranted; // string
    public $LastGainTimeDt; // date
    public $Location; // PostAddr_Type
    public $ScheduledReleaseDt; // date
    public $Sentence; // string
}

class ParoleSentenceInfo_Type {
    public $ActualEndDt; // date
    public $County; // string
    public $ProbationStatus; // string
    public $SentenceLength; // SentenceLength_Type
    public $ScheduledEndDt; // date
    public $StartDt; // date
}

class RegistrationDetails_Type {
    public $RegType; // string
    public $RegDt; // date
    public $DtType; // string
    public $PostAddr; // PostAddr_Type
    public $RegStatusCode; // CodeDescription_Type
}

class VehicleInfo_Type {
    public $AutomobileInfo; // AutomobileInfo_Type
    public $VesselInfo; // VesselInfo_Type
    public $AircraftInfo; // AircraftInfo_Type
}

class AutomobileInfo_Type {
    public $OwnerRegistrantInfo; // PersonInfo_Type
    public $Year; // date
    public $Make; // string
    public $VehicleModel; // string
    public $VehicleColor; // string
    public $PlateNum; // string
    public $RegState; // string
    public $VIN; // string
    public $OwnerIndividualSeqNum; // string
    public $CoOwnerIndividualSeqNum; // string
    public $Series; // string
    public $EngineSize; // string
    public $OdometerMileage; // string
    public $FuelType; // CodeDescription_Type
    public $VehicleUse; // CodeDescription_Type
    public $NumOfCylinders; // long
    public $MotorVehicleRegistrationOption; // CodeDescription_Type
    public $MajorColor; // CodeDescription_Type
    public $MinorColor; // CodeDescription_Type
    public $Body; // CodeDescription_Type
    public $TitleNum; // string
    public $TitleIssueDt; // date
    public $PrevTitleIssueDt; // date
    public $RecordID; // string
    public $OriginationState; // string
    public $AutoStyle; // string
    public $AutoType; // string
    public $FirstSeenDt; // date
    public $EffectiveDtRange; // DateRange_Type
    public $TitleEarliestIssueDt; // date
    public $LienDt; // date
    public $NetWeight; // long
    public $NumOfAxles; // long
    public $AutomobileExtras; // AutomobileExtras_Type
    public $PlateCode; // string
    public $PlateType; // string
    public $TruePlateNum; // string
    public $LienHolderInfo; // LienHolderInfo_Type
    public $RegistrationDetails; // RegistrationDetails_Type
    public $DecalDt; // date
    public $CheckDt; // date
    public $NewVehicleInd; // Boolean
}

class AutomobileExtras_Type {
    public $AutoExtraType; // string
    public $AutoExtraDesc; // string
}

class LienHolderInfo_Type {
    public $LienHolderType; // string
    public $PersonInfo; // PersonInfo_Type
    public $DealerLicNum; // string
    public $CommercialDates; // CommercialDates_Type
    public $LienDt; // date
}

class CommercialDates_Type {
    public $AccountingRefDt; // date
    public $AccountsLodgedDt; // date
    public $AnnualReturnDt; // date
    public $AppointmentDt; // date
    public $BirthDt; // date
    public $ClosedDt; // date
    public $CurrentDt; // date
    public $DtCreated; // date
    public $DtOfDocument; // date
    public $DtFullySatisfied; // date
    public $LatestMorgageDt; // date
    public $DtOfLatestSatisfaction; // date
    public $DtPlacedForCollection; // date
    public $ExpirationDt; // date
    public $FileDt; // date
    public $InDate; // date
    public $IncorporationDt; // date
    public $IssuedDt; // date
    public $LastActivityDt; // date
    public $LastUpdatedDt; // date
    public $LatestAccountsDt; // date
    public $LatestAccountsAtCRODt; // date
    public $LegalFormSinceDt; // date
    public $MessageDt; // date
    public $OpenedDt; // date
    public $OrderDt; // date
    public $OutDate; // date
    public $PredictedDBTDt; // date
    public $PriorMonthDt; // date
    public $RegDt; // date
    public $ResearchDt; // date
    public $ReportedDt; // date
    public $ResignationDt; // date
    public $SettledDt; // date
    public $CalculationDt; // date
    public $QuarterlyIndicator; // Boolean
    public $Quarter; // string
    public $YearOfQuarter; // string
    public $ProfileDt; // date
    public $CommencementDt; // date
    public $LeaseClosedDt; // date
    public $DueDate; // date
    public $ExtractDt; // date
    public $OrigDtFiled; // date
    public $RecentFilingDt; // date
    public $AsOfDate; // date
    public $ComplaintDeadlineDt; // date
    public $ClaimsDeadlineDt; // date
}

class VesselInfo_Type {
    public $OwnerRegistrantInfo; // PersonInfo_Type
    public $HullId; // string
    public $VesselPropulsionType; // CodeDescription_Type
    public $BoatDescription; // string
    public $HullMaterialType; // CodeDescription_Type
    public $LengthFeet; // long
    public $VesselType; // CodeDescription_Type
}

class AircraftInfo_Type {
    public $OwnerRegistrantInfo; // PersonInfo_Type
    public $DtFirstSeen; // date
    public $DtLastSeen; // date
    public $LastActionDate; // date
    public $AircraftNumber; // string
    public $CertificationDate; // date
    public $ManufacturerName; // string
    public $Model; // string
    public $AircraftType; // string
    public $EngineType; // string
    public $Engines; // string
    public $Seats; // string
    public $Category; // string
    public $Certification; // string
    public $Weight; // string
    public $CruisingSpeed; // string
    public $EngManufacturerName; // string
    public $EngHorsepower; // string
    public $EngModelName; // string
    public $EngFuelConsumption; // string
}

class Neighborhood_Type {
    public $PersonInfo; // PersonInfo_Type
    public $NeighborhoodResident; // NeighborhoodResident_Type
    public $Message; // Message_Type
}

class NeighborhoodResident_Type {
    public $PersonInfo; // PersonInfo_Type
}

class VoterRegistration_Type {
    public $PersonInfo; // PersonInfo_Type
    public $RegDt; // date
    public $PoliticalParty; // string
    public $VoterStatus; // string
    public $LastVoteDt; // date
}

class HuntingFishingLicense_Type {
    public $PersonInfo; // PersonInfo_Type
    public $LicenseNum; // string
    public $LicenseType; // string
    public $LicenseState; // string
}

class WeaponPermit_Type {
    public $PersonInfo; // PersonInfo_Type
    public $WeaponType; // string
    public $LicenseNum; // string
    public $LicenseType; // string
    public $RegDt; // date
    public $DtExpires; // date
}

class Incarceration_Type {
    public $IncarcerationDt; // date
    public $Agency; // OrgInfo_Type
    public $SentenceLength; // SentenceLength_Type
    public $TentativeReleaseDate; // date
    public $ReleaseDt; // date
    public $Message; // Message_Type
}

class Fraud_Type {
    public $FraudWarnings; // Message_Type
    public $FraudCounters; // Message_Type
    public $FraudValidations; // FraudValidations_Type
}

class FraudValidations_Type {
    public $NameValidation; // Message_Type
    public $SSNValidation; // Message_Type
    public $DOBValidation; // Message_Type
    public $DLValidation; // Message_Type
    public $DeceasedValidation; // Message_Type
    public $AddressValidation; // Message_Type
    public $PhoneValidation; // Message_Type
    public $ComboValidation; // Message_Type
    public $BusinessValidation; // Message_Type
}

class Ineligibility_Type {
    public $Grounds; // string
    public $DateRange; // DateRange_Type
}

class Attachment_Type {
    public $ContentType; // string
    public $Content; // base64Binary
    public $ContentURL; // string
}

class EvictionsCase_Type {
    public $CaseId; // string
    public $FileDt; // date
    public $CourtName; // string
    public $CountyCode; // string
    public $CourtState; // string
    public $Book; // string
    public $Page; // string
    public $FileName; // string
    public $FilingState; // string
    public $FilingType; // string
    public $AssetAmt; // CurrencyAmount
    public $LiabilityAmt; // CurrencyAmount
    public $JudgmentAmt; // CurrencyAmount
    public $Sch341DtTime; // string
    public $EvictionsData; // Message_Type
    public $RecordID; // string
    public $IRSSerialNum; // string
    public $OrigFilingNum; // string
    public $OrigFilingType; // string
    public $FilingAmt; // CurrencyAmount
    public $FilingJurisdiction; // string
    public $FilingLocation; // string
    public $FilingStatus; // string
}

class ClosureInfo_Type {
    public $ClosureStats; // Message_Type
    public $CollectionAmt; // CurrencyAmount
    public $ChargeOffAmt; // CurrencyAmount
    public $ClosureReason; // Message_Type
    public $ClosureData; // Message_Type
    public $Event; // Event_Type
    public $PersonInfo; // PersonInfo_Type
    public $ReportedOrg; // OrgInfo_Type
    public $ReportingOrg; // OrgInfo_Type
    public $Message; // Message_Type
}

class Event_Type {
    public $EventDt; // date
    public $EventType; // string
    public $FilingType; // string
    public $DocumentNumber; // string
    public $Message; // Message_Type
    public $PostAddr; // PostAddr_Type
}

class Inquiry_Type {
    public $InqDt; // date
    public $OrgInfo; // OrgInfo_Type
    public $CreditLoanType; // string
    public $Terms; // string
    public $InqResult; // string
    public $AcctId; // string
    public $InquiryAmt; // CurrencyAmount
    public $InquiryType; // string
    public $Message; // Message_Type
}

class BusinessInquiry_Type {
    public $OrgInfo; // OrgInfo_Type
    public $Inquiry; // Inquiry_Type
    public $Message; // Message_Type
}

class QFInformation_Type {
    public $QFAcctAction; // Message_Type
    public $Score; // Score_Type
    public $QFProdOffer; // QFProdOffer_Type
    public $QFScore; // Score_Type
    public $Message; // Message_Type
}

class Score_Type {
    public $Model; // string
    public $Value; // long
    public $Alert; // CodeDescription_Type
    public $Factor; // CodeDescription_Type
    public $ModelNumber; // string
    public $ScoreNumberInd; // string
    public $Message; // Message_Type
    public $ModelDesc; // string
}

class QFProdOffer_Type {
    public $MsgClass; // string
    public $ProdOfferLmtAmt; // CurrencyAmount
    public $ProdOfferTxt; // string
    public $ProdOfferPercent; // decimal
}

class LiabilitySummary_Type {
    public $MsgClass; // string
    public $TotalNumTrades; // long
    public $TotalNumTradesWithBalance; // long
    public $TotalBalanceAmt; // CurrencyAmount
    public $TotalScheduledMoPmtAmt; // CurrencyAmount
    public $TotalHC_CLAmt; // CurrencyAmount
    public $LateCount30; // long
    public $LateCount60; // long
    public $LateCount90; // long
    public $AvailablePercentage; // decimal
}

class AuthConfig_Type {
    public $NumOfQuestions; // long
    public $QuestionConfig; // QuestionConfig_Type
}

class QuestionConfig_Type {
    public $QuestionID; // string
    public $NumOfAnswers; // long
    public $NumOfCorrectAnswers; // long
}

class QuestionsAnswers_Type {
    public $QuestionID; // string
    public $MultipleCorrectAnswers; // Boolean
    public $QuestionText; // string
    public $QuestionInfo; // string
    public $Answers; // Answers_Type
    public $SubQuestions; // SubQuestions_Type
    public $InvalidAnswers; // InvalidAnswers_Type
}

class Answers_Type {
    public $AnswerValue; // string
    public $AnswerIsCorrect; // Boolean
}

class SubQuestions_Type {
    public $QuestionText; // string
    public $AnswerValue; // string
}

class InvalidAnswers_Type {
    public $InvalidAnswer; // string
}

class AccountingInfo_Type {
    public $MsgClass; // string
    public $AccountingPeriodInfo; // PeriodInfo_Type
    public $AccountingElementsInfo; // ElementsInfo_Type
}

class PeriodInfo_Type {
    public $PeriodIndicator; // long
    public $PeriodDt; // date
    public $Message; // Message_Type
}

class InternationalCourtInfo_Type {
    public $IntlCourtDetailsInfo; // IntlCourtDetailsInfo_Type
    public $IntlCourtPeriodInfo; // IntlCourtPeriodInfo_Type
    public $IntlCourtElementsInfo; // IntlCourtElementsInfo_Type
    public $Message; // Message_Type
}

class IntlCourtDetailsInfo_Type {
    public $MsgClass; // string
    public $CaseId; // string
    public $CourtName; // string
    public $JudgmentAmt; // CurrencyAmount
    public $JudgmentDt; // date
    public $CourtType; // string
    public $Message; // Message_Type
}

class IntlCourtPeriodInfo_Type {
    public $MsgClass; // string
    public $Months; // long
    public $IntlCourtDt; // date
}

class IntlCourtElementsInfo_Type {
    public $MsgClass; // string
    public $IntlCourtAmt; // CurrencyAmount
    public $IntlCourtCount; // long
    public $PercentageRatio; // decimal
}

class CompanyHistory_Type {
    public $Message; // Message_Type
}

class CorporateCreditRating_Type {
    public $CreditRating; // CreditRating_Type
    public $HistoricalCreditRating; // CreditRating_Type
    public $Message; // Message_Type
}

class CreditRating_Type {
    public $MsgClass; // string
    public $Period; // string
    public $TimeScale; // string
    public $RatingType; // string
    public $RatingAmt; // CurrencyAmount
    public $RatingDt; // date
    public $Score; // Score_Type
    public $Message; // Message_Type
}

class EconomicInfo_Type {
    public $Message; // Message_Type
}

class DebtSummary_Type {
    public $Message; // Message_Type
}

class FinancialSummary_Type {
    public $SalesAmt; // CurrencyAmount
    public $NetIncomeAmt; // CurrencyAmount
    public $SummaryDt; // date
    public $Message; // Message_Type
}

class InformationSummary_Type {
    public $InformationDetail; // InformationDetail_Type
}

class InformationDetail_Type {
    public $Message; // Message_Type
}

class KeyIndustrySectorTrends_Type {
    public $MsgClass; // string
    public $SectorPeriodInfo; // PeriodInfo_Type
    public $SectorElementsInfo; // ElementsInfo_Type
    public $Message; // Message_Type
}

class LegalFormsInfo_Type {
    public $Message; // Message_Type
}

class RegisteredCharge_Type {
    public $CommercialDates; // CommercialDates_Type
    public $Message; // Message_Type
}

class RegisteredChargesDetails_Type {
    public $CommercialDates; // CommercialDates_Type
    public $CommercialAmounts; // CommercialAmounts_Type
    public $OrgInfo; // OrgInfo_Type
    public $Message; // Message_Type
    public $RegState; // string
    public $FilingNum; // string
    public $FilingStatus; // string
}

class CommercialAmounts_Type {
    public $AssetAmt; // CurrencyAmount
    public $CreditLimitAmt; // CurrencyAmount
    public $Income; // CurrencyAmount
    public $AnswerLimitAmt; // CurrencyAmount
    public $AvgMonthlyCreditAmt; // CurrencyAmount
    public $CapitalStockAmt; // CurrencyAmount
    public $ClosingAmt; // CurrencyAmount
    public $IssuedCapitalAmt; // CurrencyAmount
    public $NetIncomeAmt; // CurrencyAmount
    public $NominalCapitalAmt; // CurrencyAmount
    public $OpeningAmt; // CurrencyAmount
    public $SalesAmt; // CurrencyAmount
    public $TotalAmt; // CurrencyAmount
    public $ValueAmt; // CurrencyAmount
    public $VATAmt; // CurrencyAmount
    public $WorkingCapitalAmt; // CurrencyAmount
    public $NominalNum; // string
    public $CreditorsDaysDPO; // long
    public $DaysOfCredit; // long
    public $IssuedNum; // long
    public $NumOfShareholders; // long
    public $NumOfShares; // long
    public $NumOutstanding; // long
    public $NumPartiallySatisfied; // long
    public $NumRegistered; // long
    public $NumSatisfied; // long
    public $Quantity; // long
    public $TotalCount; // long
    public $CurrencyRate; // decimal
    public $GearingPercent; // decimal
    public $LeveragePercent; // decimal
    public $OddsFinancialStressNext12Months; // decimal
    public $PaymentTrend; // decimal
    public $PercentAtAndAboveScore; // decimal
    public $PercentFacedFinancialStress; // decimal
    public $PercentOfShares; // decimal
    public $QuickRatioPercent; // decimal
    public $BusinessDBT; // string
    public $PredictedDBTAmt; // CurrencyAmount
    public $AllIndustryDBT; // string
    public $LowTotalAcctBalAmt; // CurrencyAmount
    public $LowTotalAcctBalModifier; // string
    public $HighTotalAcctBalAmt; // CurrencyAmount
    public $HighTotalAcctBalModifier; // string
    public $CurTotalAcctBalAmt; // CurrencyAmount
    public $CurTotalAcctBalModifier; // string
    public $HighCreditExtendedAmt; // CurrencyAmount
    public $MedCreditExtendedAmt; // CurrencyAmount
    public $AmtPlacedForCollection; // CurrencyAmount
    public $AmtPaid; // CurrencyAmount
    public $RecentHighCreditAmt; // CurrencyAmount
    public $RecentHighCreditModifier; // string
    public $BalanceAmt; // CompAmt_Type
    public $BalanceAmtModifier; // string
    public $Terms; // string
    public $CurrentPercentage; // decimal
    public $DBT30Percentage; // decimal
    public $DBT60Percentage; // decimal
    public $DBT90Percentage; // decimal
    public $DBT90PlusPercentage; // decimal
    public $ContributorComments; // string
    public $ConsumerStatementPresent; // Boolean
    public $LiabilityAmt; // CurrencyAmount
    public $NumPmtsPerYear; // long
    public $LateCount30; // long
    public $LateCount60; // long
    public $LateCount90; // long
    public $LateCount120; // long
    public $ScheduledPmtAmt; // CurrencyAmount
    public $ScheduledPmtAmtModifier; // string
    public $NumOfOverduePmts; // long
    public $PmtOverdueAmt; // CurrencyAmount
    public $PmtOverdueAmtModifier; // string
    public $CurrentPmtAmt; // CurrencyAmount
    public $CurrentPmtAmtModifier; // string
    public $TotalLatePmtAmt; // CurrencyAmount
    public $TotalLatePmtAmtModifier; // string
    public $Amt30DaysLate; // CurrencyAmount
    public $Amt30DaysLateModifier; // string
    public $Amt60DaysLate; // CurrencyAmount
    public $Amt60DaysLateModifier; // string
    public $Amt90DaysLate; // CurrencyAmount
    public $Amt90DaysLateModifier; // string
    public $Amt90PlusDaysLate; // CurrencyAmount
    public $Amt90PlusDaysLateModifier; // string
    public $FilingAmt; // CurrencyAmount
}

class RegisteredChargesSummary_Type {
    public $CommercialDates; // CommercialDates_Type
    public $CommercialAmounts; // CommercialAmounts_Type
    public $Message; // Message_Type
}

class RegisteredChargesInfo_Type {
    public $RegisteredChargesSummary; // RegisteredChargesSummary_Type
    public $RegisteredChargesDetails; // RegisteredChargesDetails_Type
    public $RegisteredCharge; // RegisteredCharge_Type
}

class ShareCapitalSummary_Type {
    public $ShareCapital; // ShareCapital_Type
    public $Message; // Message_Type
}

class ShareCapital_Type {
    public $CommercialAmounts; // CommercialAmounts_Type
    public $Message; // Message_Type
}

class StockExchangeInfo_Type {
    public $Message; // Message_Type
}

class TradeCountries_Type {
    public $Country; // string
    public $Message; // Message_Type
}

class TradeReferenceSummary_Type {
    public $TradeReferenceDetailInfo; // TradeReferenceDetailInfo_Type
    public $TradeReferenceElementInfo; // TradeReferenceElementInfo_Type
    public $Message; // Message_Type
}

class TradeReferenceDetailInfo_Type {
    public $CommercialDates; // CommercialDates_Type
    public $CommercialAmounts; // CommercialAmounts_Type
    public $Message; // Message_Type
}

class TradeReferenceElementInfo_Type {
    public $CommercialAmounts; // CommercialAmounts_Type
}

class ExchangeRateInfo_Type {
    public $ResearchDt; // date
    public $CurCode; // string
    public $Message; // Message_Type
}

class DocumentInfo_Type {
    public $CategoryType; // string
    public $DocSource; // string
    public $DocType; // string
    public $DtOfDocument; // date
    public $Message; // Message_Type
}

class CRASummary_Type {
    public $MsgClass; // string
    public $CRACode; // string
    public $CreditObligationsReportedCount; // long
    public $InqCount; // long
    public $MonthsSinceMostRecentInquiry; // string
    public $MonthsSinceMostRecentAdversePR; // string
    public $MonthsSinceMostRecentCollectionAssigned; // string
    public $MonthsSinceOldestTradelineOpened; // string
    public $MaxDelinquencyEver; // CodeDescription_Type
    public $MonthsSinceMostRecentDelinquency; // string
    public $CreditObligationsWithBalanceCount; // long
    public $TotalBalancesOnCRAmt; // CurrencyAmount
}

class EBAddOns_Type {
    public $ReqAR; // Boolean
    public $ReqBOP; // Boolean
    public $ReqBP; // Boolean
    public $ReqBSUM; // Boolean
    public $ReqDS; // string
    public $ReqIR; // Boolean
    public $ReqITP; // Boolean
    public $ReqLOS; // Boolean
    public $ReqMC; // string
    public $ReqRLCD; // Boolean
    public $ReqSA; // Boolean
    public $ReqUCC; // Boolean
    public $ReqDI; // Boolean
}

class CommercialExecutiveSummary_Type {
    public $CommercialAmounts; // CommercialAmounts_Type
    public $CommercialDates; // CommercialDates_Type
    public $IndustryPmtComparison; // CodeDescription_Type
    public $PmtTrendInd; // CodeDescription_Type
    public $IndustryDescription; // string
    public $CommonPmtTerms; // string
    public $Message; // Message_Type
}

class CommercialCollectionInfo_Type {
    public $AcctStatus; // string
    public $CommercialDates; // CommercialDates_Type
    public $CommercialAmounts; // CommercialAmounts_Type
    public $OrgInfo; // OrgInfo_Type
    public $ConsumerStatementPresent; // Boolean
    public $Message; // Message_Type
}

class CommercialPmtInfo_Type {
    public $IndustryPmtIndicator; // string
    public $OrgId; // OrgId_Type
    public $CommercialDates; // CommercialDates_Type
    public $CommercialAmounts; // CommercialAmounts_Type
    public $Message; // Message_Type
}

class CommercialPmtTotals_Type {
    public $MsgClass; // string
    public $TotalTrades; // long
    public $BusinessDBT; // string
    public $CommercialAmounts; // CommercialAmounts_Type
    public $Message; // Message_Type
}

class CommercialPmtTrends_Type {
    public $MsgClass; // string
    public $IndustId; // IndustId_Type
    public $CommercialDates; // CommercialDates_Type
    public $CommercialAmounts; // CommercialAmounts_Type
    public $BusinessDBT; // string
    public $Message; // Message_Type
}

class CommercialPublicRecords_Type {
    public $PRType; // string
    public $PRStatus; // string
    public $CommercialDates; // CommercialDates_Type
    public $CommercialAmounts; // CommercialAmounts_Type
    public $TaxLienCode; // CodeDescription_Type
    public $Parties; // Parties_Type
    public $DisputeInd; // Boolean
    public $Message; // Message_Type
    public $CourtName; // string
    public $CourtNum; // string
    public $CaseId; // string
    public $OrigCase; // string
    public $Chapter; // string
    public $OrigChapter; // string
    public $FilingStatus; // string
    public $Event; // Event_Type
    public $SelfRepresentedInd; // Boolean
    public $AssetsAvailForUnsecuredInd; // Boolean
}

class Parties_Type {
    public $Ruling; // string
    public $PartyType; // string
    public $PersonInfo; // PersonInfo_Type
    public $RecordID; // string
    public $Message; // Message_Type
    public $OrgInfo; // OrgInfo_Type
}

class CommercialUCCSummary_Type {
    public $TotalUCCFilingCount; // long
    public $SummaryCountTimeFrame; // SummaryCountTimeFrame_Type
}

class SummaryCountTimeFrame_Type {
    public $MsgClass; // string
    public $CommercialDates; // CommercialDates_Type
    public $CommercialAmounts; // CommercialAmounts_Type
    public $FilingCount; // string
    public $TotalDerogatoryCollateralFilings; // long
    public $TotalReleasesTerminations; // long
    public $TotalContinuations; // long
    public $TotalAmendedAssigned; // long
}

class OfficersDirectors_Type {
    public $PersonInfo; // PersonInfo_Type
    public $OrgInfo; // OrgInfo_Type
    public $Message; // Message_Type
    public $AsOfDate; // date
    public $DtFirstSeen; // date
    public $DtLastSeen; // date
    public $RecordID; // string
    public $HistoricalInd; // Boolean
}

class CommercialUCC_Type {
    public $CommercialDates; // CommercialDates_Type
    public $PRType; // string
    public $PRStatus; // string
    public $DocumentNumber; // string
    public $FilingState; // string
    public $FilingLocation; // string
    public $Parties; // Parties_Type
    public $CollateralInfo; // CollateralInfo_Type
    public $DisputeInd; // Boolean
    public $Event; // Event_Type
    public $OfficersDirectors; // OfficersDirectors_Type
    public $Message; // Message_Type
}

class CollateralInfo_Type {
    public $CollateralDesc; // string
    public $CollateralCount; // long
    public $PropertyDesc; // string
    public $PropertyAddress; // PostAddr_Type
    public $SerialNum; // string
    public $Message; // Message_Type
    public $PrimaryMachine; // string
    public $SecondMachine; // string
    public $ManufacturerName; // string
    public $Year; // date
    public $Model; // string
    public $ManufacturedDt; // date
    public $Borough; // string
    public $Lot; // string
    public $AirRights; // string
    public $SubterraneanRights; // string
    public $Easement; // string
    public $NewUsed; // string
}

class OriginalUCCInfo_Type {
    public $PRStatus; // string
    public $FilingState; // string
    public $DocumentNumber; // string
    public $FileDt; // date
}

class CommercialEntityInfo_Type {
    public $MsgClass; // string
    public $RelationshipType; // string
    public $OrgInfo; // OrgInfo_Type
    public $CommercialAmounts; // CommercialAmounts_Type
    public $CommercialDates; // CommercialDates_Type
    public $DisputeInd; // Boolean
    public $CommercialCodes; // Message_Type
}

class CommercialLeasingInfo_Type {
    public $LeasingCompany; // OrgInfo_Type
    public $CommercialAmounts; // CommercialAmounts_Type
    public $CommercialDates; // CommercialDates_Type
    public $Terms; // string
    public $PmtFreq; // string
    public $PmtType; // CodeDescription_Type
    public $ProductType; // string
    public $LeaseType; // string
    public $DisputeInd; // Boolean
    public $Message; // Message_Type
}

class CommercialFilings_Type {
    public $OriginationState; // string
    public $CorpID; // string
    public $FilingType; // string
    public $CommercialDates; // CommercialDates_Type
    public $OrgInfo; // OrgInfo_Type
    public $IncorporationState; // string
    public $FilingState; // string
    public $CorpStatus; // string
    public $TermType; // string
    public $ForProfitInd; // Boolean
    public $Parties; // Parties_Type
    public $FilingStatus; // string
    public $FilingNum; // string
    public $SerialNum; // string
    public $Page; // string
}

class Associate_Type {
    public $PersonInfo; // PersonInfo_Type
    public $Message; // Message_Type
}

class EvictionsDates_Type {
    public $OrigDtFiled; // date
    public $JudgeSatisfiedDt; // date
    public $JudgeVacatedDt; // date
    public $SuitDt; // date
    public $ReleaseDt; // date
}

class FilingsInfo_Type {
    public $FilingNum; // string
    public $FilingType; // string
    public $FilingDt; // date
    public $Book; // string
    public $Page; // string
    public $Agency; // OrgInfo_Type
}

class LoanRequestInfo_Type {
    public $RequestedCreditAmt; // CurrencyAmount
    public $DownPmtAmt; // CurrencyAmount
    public $MonthlyPmtAmt; // CurrencyAmount
    public $Terms; // string
    public $RefinanceCode; // string
    public $BookValueAmt; // CurrencyAmount
    public $CostOfGoodsAmt; // CurrencyAmount
    public $TotalLiquidAssetsAmt; // CurrencyAmount
    public $HousingType; // string
    public $DwellingStructureType; // string
    public $MortgageRentAmt; // CurrencyAmount
    public $MortgageAmt; // CurrencyAmount
    public $MortgageBalAmt; // CurrencyAmount
    public $LoanType; // string
    public $MonthlyDebtAmt; // CurrencyAmount
    public $BankruptcyOnApp; // Boolean
    public $RepossessionOnApp; // Boolean
    public $ForeclosureOnApp; // Boolean
}

class Report_Type {
    public $Bureau; // string
    public $Product; // string
    public $ARStatus; // string
    public $GUID; // string
}

class ACHInfo_Type {
    public $CheckRoutingNum; // string
    public $CheckAcctNum; // string
    public $CheckAcctType; // string
    public $CheckNum; // string
    public $CheckEntryClassCd; // string
    public $CheckDt; // date
}

class CreditCardInfo_Type {
    public $CreditCardNum; // string
    public $ExpirationDt; // date
    public $SecurityDigits; // string
    public $PersonInfo; // PersonInfo_Type
}

class MICRInfo_Type {
    public $MICRType; // string
    public $MICRNum; // string
    public $TOADValue; // string
    public $RoutingNumber; // string
    public $AccountNum; // string
    public $SwipedInd; // Boolean
    public $FullMICRLine; // string
}

class Transaction_Type {
    public $TransNum; // string
    public $TransEntityName; // string
    public $TransType; // string
    public $TransAmt; // CurrencyAmount
    public $TransDt; // date
    public $Message; // Message_Type
}

class Transactions_Type {
    public $Transaction; // Transaction_Type
}

class CivilCourt_Type {
    public $Parties; // Parties_Type
    public $Event; // Event_Type
    public $CriminalCase; // CriminalCase_Type
    public $VehicleInfo; // VehicleInfo_Type
}

class PassportInfo_Type {
    public $Country; // string
    public $PassportNum; // string
    public $IssuedDt; // date
    public $ExpirationDt; // date
}

class MilitaryIdInfo_Type {
    public $MilitaryIdNum; // string
    public $IssuedDt; // date
    public $ExpirationDt; // date
}

class PhysicalCharacteristics_Type {
    public $Age; // string
    public $Race; // string
    public $Ethnicity; // string
    public $Gender; // string
    public $HairColor; // string
    public $EyeColor; // string
    public $Height; // string
    public $Weight; // string
    public $SkinTone; // string
    public $BuildType; // string
    public $IdentifyingMarks; // string
    public $ShoeSize; // string
    public $CorrectiveLenses; // Boolean
}

class SchoolInfo_Type {
    public $OrgInfo; // OrgInfo_Type
    public $StartDt; // date
    public $EndDt; // date
    public $GraduationDt; // date
    public $Diploma; // string
    public $DegreeMajor; // string
    public $DegreeMinor; // string
    public $Message; // Message_Type
}

class EmploymentHistory_Type {
    public $EmploymentStatus; // string
    public $OrgInfo; // OrgInfo_Type
    public $Occupation; // string
    public $Income; // CurrencyAmount
    public $PmtFreq; // string
    public $JobTitle; // string
    public $StartDt; // date
    public $EndDt; // date
    public $VerifiedDt; // date
    public $VerificationCode; // string
}

class SpouseInfo_Type {
    public $PersonName; // PersonName_Type
    public $ContactInfo; // ContactInfo_Type
    public $TINInfo; // TINInfo_Type
    public $BirthDt; // date
    public $DeathDt; // date
    public $DriversLicense; // DriversLicense_Type
    public $MothersMaidenName; // string
    public $EmploymentHistory; // EmploymentHistory_Type
}

class DriversLicense_Type {
    public $LicenseNum; // string
    public $StateProv; // string
    public $Country; // string
    public $DriverOption; // CodeDescription_Type
    public $DLClass; // string
    public $DLType; // string
    public $DLStatus; // string
    public $CDLStatus; // string
    public $Endorsements; // Option_Type
    public $Restrictions; // Option_Type
    public $IssuedDt; // date
    public $ExpirationDt; // date
    public $Message; // Message_Type
}

class Option_Type {
    public $OptionName; // string
    public $OptionValue; // Boolean
}

class MsgRsHdr_Type {
    public $RqUID; // string
    public $Status; // Status_Type
}

class Status_Type {
    public $StatusCode; // long
    public $ServerStatusCode; // string
    public $Severity; // Severity_Type
    public $StatusDesc; // string
    public $AdditionalStatus; // AdditionalStatus_Type
}

class Severity_Type {
}

class AdditionalStatus_Type {
    public $StatusCode; // long
    public $ServerStatusCode; // string
    public $Severity; // Severity_Type
    public $StatusDesc; // string
}

class MBPeopleSearchRq_Type {
    public $MsgRqHdr; // MsgRqHdr_Type
    public $PersonInfo; // PersonInfo_Type
}

class MBPeopleSearchRs_Type {
    public $MsgRsHdr; // MsgRsHdr_Type
    public $Subject; // Subject
}

class Subject {
    public $RefNum; // string
    public $PersonInfo; // PersonInfo_Type
    public $Alias; // PersonInfo_Type
    public $DateRange; // DateRange_Type
    public $Message; // Message_Type
}

class GetReport {
    public $inquiry; // MBPeopleSearchRq_Type
}

class GetReportResponse {
    public $GetReportResult; // MBPeopleSearchRs_Type
}

class GetRawReport {
    public $guid; // string
}

class GetRawReportResponse {
    public $GetRawReportResult; // string
}

class GetArchiveReport {
    public $guid; // string
}

class GetArchiveReportResponse {
    public $GetArchiveReportResult; // MBPeopleSearchRs_Type
}


/**
 * MBPeopleSearchSvc class
 *
 *
 *
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class MBPeopleSearchSvc extends SoapClient {

    private static $classmap = array(
        'MsgRqHdr_Type' => 'MsgRqHdr_Type',
        'RequestType' => 'RequestType',
        'PersonInfo_Type' => 'PersonInfo_Type',
        'Aggregate' => 'Aggregate',
        'Summary_Type' => 'Summary_Type',
        'CompAmt_Type' => 'CompAmt_Type',
        'CurrencyAmount' => 'CurrencyAmount',
        'Message_Type' => 'Message_Type',
        'Liability_Type' => 'Liability_Type',
        'OrgInfo_Type' => 'OrgInfo_Type',
        'IndustId_Type' => 'IndustId_Type',
        'CodeDescription_Type' => 'CodeDescription_Type',
        'ContactInfo_Type' => 'ContactInfo_Type',
        'PhoneNum_Type' => 'PhoneNum_Type',
        'Boolean' => 'Boolean',
        'PostAddr_Type' => 'PostAddr_Type',
        'GEOCode_Type' => 'GEOCode_Type',
        'ValidationInfo_Type' => 'ValidationInfo_Type',
        'TINInfo_Type' => 'TINInfo_Type',
        'DateRange_Type' => 'DateRange_Type',
        'OtherTaxId_Type' => 'OtherTaxId_Type',
        'OrgId_Type' => 'OrgId_Type',
        'CharterInfo_Type' => 'CharterInfo_Type',
        'Rating_Type' => 'Rating_Type',
        'PaymentInfo_Type' => 'PaymentInfo_Type',
        'CategoryInfo_Type' => 'CategoryInfo_Type',
        'ElementsInfo_Type' => 'ElementsInfo_Type',
        'AmtItems_Type' => 'AmtItems_Type',
        'PublicRecord_Type' => 'PublicRecord_Type',
        'CourtInfo_Type' => 'CourtInfo_Type',
        'Release_Type' => 'Release_Type',
        'SentenceLength_Type' => 'SentenceLength_Type',
        'SubjectConfirmation_Type' => 'SubjectConfirmation_Type',
        'Accident_Type' => 'Accident_Type',
        'AccidentLocation_Type' => 'AccidentLocation_Type',
        'AccidentTime_Type' => 'AccidentTime_Type',
        'Conditions_Type' => 'Conditions_Type',
        'Investigation_Type' => 'Investigation_Type',
        'AccidentStatistics_Type' => 'AccidentStatistics_Type',
        'Violation_Type' => 'Violation_Type',
        'DecisionTable_Type' => 'DecisionTable_Type',
        'DecisionTableSummary_Type' => 'DecisionTableSummary_Type',
        'DecisionTableDetails_Type' => 'DecisionTableDetails_Type',
        'BankStatement_Type' => 'BankStatement_Type',
        'BankAccount_Type' => 'BankAccount_Type',
        'ApplicantData_Type' => 'ApplicantData_Type',
        'ChargeOff_Type' => 'ChargeOff_Type',
        'PmtAgreement_Type' => 'PmtAgreement_Type',
        'OFAC_Type' => 'OFAC_Type',
        'AddressInfo_Type' => 'AddressInfo_Type',
        'PhoneInfo_Type' => 'PhoneInfo_Type',
        'PersonName_Type' => 'PersonName_Type',
        'DataIndicators_Type' => 'DataIndicators_Type',
        'LoanParams_Type' => 'LoanParams_Type',
        'LoanInfo_Type' => 'LoanInfo_Type',
        'PathInfo_Type' => 'PathInfo_Type',
        'VariableInfo_Type' => 'VariableInfo_Type',
        'Decision_Type' => 'Decision_Type',
        'DecisionInfo_Type' => 'DecisionInfo_Type',
        'VictimInfo_Type' => 'VictimInfo_Type',
        'TransactionFee_Type' => 'TransactionFee_Type',
        'UCC_Type' => 'UCC_Type',
        'InternetDomain_Type' => 'InternetDomain_Type',
        'Relative_Type' => 'Relative_Type',
        'OffenderRef_Type' => 'OffenderRef_Type',
        'SexualOffense_Type' => 'SexualOffense_Type',
        'CriminalCase_Type' => 'CriminalCase_Type',
        'Charge_Type' => 'Charge_Type',
        'PrisonSentenceInfo_Type' => 'PrisonSentenceInfo_Type',
        'ParoleSentenceInfo_Type' => 'ParoleSentenceInfo_Type',
        'RegistrationDetails_Type' => 'RegistrationDetails_Type',
        'VehicleInfo_Type' => 'VehicleInfo_Type',
        'AutomobileInfo_Type' => 'AutomobileInfo_Type',
        'AutomobileExtras_Type' => 'AutomobileExtras_Type',
        'LienHolderInfo_Type' => 'LienHolderInfo_Type',
        'CommercialDates_Type' => 'CommercialDates_Type',
        'VesselInfo_Type' => 'VesselInfo_Type',
        'AircraftInfo_Type' => 'AircraftInfo_Type',
        'Neighborhood_Type' => 'Neighborhood_Type',
        'NeighborhoodResident_Type' => 'NeighborhoodResident_Type',
        'VoterRegistration_Type' => 'VoterRegistration_Type',
        'HuntingFishingLicense_Type' => 'HuntingFishingLicense_Type',
        'WeaponPermit_Type' => 'WeaponPermit_Type',
        'Incarceration_Type' => 'Incarceration_Type',
        'Fraud_Type' => 'Fraud_Type',
        'FraudValidations_Type' => 'FraudValidations_Type',
        'Ineligibility_Type' => 'Ineligibility_Type',
        'Attachment_Type' => 'Attachment_Type',
        'EvictionsCase_Type' => 'EvictionsCase_Type',
        'ClosureInfo_Type' => 'ClosureInfo_Type',
        'Event_Type' => 'Event_Type',
        'Inquiry_Type' => 'Inquiry_Type',
        'BusinessInquiry_Type' => 'BusinessInquiry_Type',
        'QFInformation_Type' => 'QFInformation_Type',
        'Score_Type' => 'Score_Type',
        'QFProdOffer_Type' => 'QFProdOffer_Type',
        'LiabilitySummary_Type' => 'LiabilitySummary_Type',
        'AuthConfig_Type' => 'AuthConfig_Type',
        'QuestionConfig_Type' => 'QuestionConfig_Type',
        'QuestionsAnswers_Type' => 'QuestionsAnswers_Type',
        'Answers_Type' => 'Answers_Type',
        'SubQuestions_Type' => 'SubQuestions_Type',
        'InvalidAnswers_Type' => 'InvalidAnswers_Type',
        'AccountingInfo_Type' => 'AccountingInfo_Type',
        'PeriodInfo_Type' => 'PeriodInfo_Type',
        'InternationalCourtInfo_Type' => 'InternationalCourtInfo_Type',
        'IntlCourtDetailsInfo_Type' => 'IntlCourtDetailsInfo_Type',
        'IntlCourtPeriodInfo_Type' => 'IntlCourtPeriodInfo_Type',
        'IntlCourtElementsInfo_Type' => 'IntlCourtElementsInfo_Type',
        'CompanyHistory_Type' => 'CompanyHistory_Type',
        'CorporateCreditRating_Type' => 'CorporateCreditRating_Type',
        'CreditRating_Type' => 'CreditRating_Type',
        'EconomicInfo_Type' => 'EconomicInfo_Type',
        'DebtSummary_Type' => 'DebtSummary_Type',
        'FinancialSummary_Type' => 'FinancialSummary_Type',
        'InformationSummary_Type' => 'InformationSummary_Type',
        'InformationDetail_Type' => 'InformationDetail_Type',
        'KeyIndustrySectorTrends_Type' => 'KeyIndustrySectorTrends_Type',
        'LegalFormsInfo_Type' => 'LegalFormsInfo_Type',
        'RegisteredCharge_Type' => 'RegisteredCharge_Type',
        'RegisteredChargesDetails_Type' => 'RegisteredChargesDetails_Type',
        'CommercialAmounts_Type' => 'CommercialAmounts_Type',
        'RegisteredChargesSummary_Type' => 'RegisteredChargesSummary_Type',
        'RegisteredChargesInfo_Type' => 'RegisteredChargesInfo_Type',
        'ShareCapitalSummary_Type' => 'ShareCapitalSummary_Type',
        'ShareCapital_Type' => 'ShareCapital_Type',
        'StockExchangeInfo_Type' => 'StockExchangeInfo_Type',
        'TradeCountries_Type' => 'TradeCountries_Type',
        'TradeReferenceSummary_Type' => 'TradeReferenceSummary_Type',
        'TradeReferenceDetailInfo_Type' => 'TradeReferenceDetailInfo_Type',
        'TradeReferenceElementInfo_Type' => 'TradeReferenceElementInfo_Type',
        'ExchangeRateInfo_Type' => 'ExchangeRateInfo_Type',
        'DocumentInfo_Type' => 'DocumentInfo_Type',
        'CRASummary_Type' => 'CRASummary_Type',
        'EBAddOns_Type' => 'EBAddOns_Type',
        'CommercialExecutiveSummary_Type' => 'CommercialExecutiveSummary_Type',
        'CommercialCollectionInfo_Type' => 'CommercialCollectionInfo_Type',
        'CommercialPmtInfo_Type' => 'CommercialPmtInfo_Type',
        'CommercialPmtTotals_Type' => 'CommercialPmtTotals_Type',
        'CommercialPmtTrends_Type' => 'CommercialPmtTrends_Type',
        'CommercialPublicRecords_Type' => 'CommercialPublicRecords_Type',
        'Parties_Type' => 'Parties_Type',
        'CommercialUCCSummary_Type' => 'CommercialUCCSummary_Type',
        'SummaryCountTimeFrame_Type' => 'SummaryCountTimeFrame_Type',
        'OfficersDirectors_Type' => 'OfficersDirectors_Type',
        'CommercialUCC_Type' => 'CommercialUCC_Type',
        'CollateralInfo_Type' => 'CollateralInfo_Type',
        'OriginalUCCInfo_Type' => 'OriginalUCCInfo_Type',
        'CommercialEntityInfo_Type' => 'CommercialEntityInfo_Type',
        'CommercialLeasingInfo_Type' => 'CommercialLeasingInfo_Type',
        'CommercialFilings_Type' => 'CommercialFilings_Type',
        'Associate_Type' => 'Associate_Type',
        'EvictionsDates_Type' => 'EvictionsDates_Type',
        'FilingsInfo_Type' => 'FilingsInfo_Type',
        'LoanRequestInfo_Type' => 'LoanRequestInfo_Type',
        'Report_Type' => 'Report_Type',
        'ACHInfo_Type' => 'ACHInfo_Type',
        'CreditCardInfo_Type' => 'CreditCardInfo_Type',
        'MICRInfo_Type' => 'MICRInfo_Type',
        'Transaction_Type' => 'Transaction_Type',
        'Transactions_Type' => 'Transactions_Type',
        'CivilCourt_Type' => 'CivilCourt_Type',
        'PassportInfo_Type' => 'PassportInfo_Type',
        'MilitaryIdInfo_Type' => 'MilitaryIdInfo_Type',
        'PhysicalCharacteristics_Type' => 'PhysicalCharacteristics_Type',
        'SchoolInfo_Type' => 'SchoolInfo_Type',
        'EmploymentHistory_Type' => 'EmploymentHistory_Type',
        'SpouseInfo_Type' => 'SpouseInfo_Type',
        'DriversLicense_Type' => 'DriversLicense_Type',
        'Option_Type' => 'Option_Type',
        'MsgRsHdr_Type' => 'MsgRsHdr_Type',
        'Status_Type' => 'Status_Type',
        'Severity_Type' => 'Severity_Type',
        'AdditionalStatus_Type' => 'AdditionalStatus_Type',
        'MBPeopleSearchRq_Type' => 'MBPeopleSearchRq_Type',
        'MBPeopleSearchRs_Type' => 'MBPeopleSearchRs_Type',
        'Subject' => 'Subject',
        'GetReport' => 'GetReport',
        'GetReportResponse' => 'GetReportResponse',
        'GetRawReport' => 'GetRawReport',
        'GetRawReportResponse' => 'GetRawReportResponse',
        'GetArchiveReport' => 'GetArchiveReport',
        'GetArchiveReportResponse' => 'GetArchiveReportResponse',
    );

    public function MBPeopleSearchSvc($wsdl = "https://creditserver.microbilt.com/WebServices/MBPeopleSearch/MBPeopleSearch.svc?wsdl", $options = array()) {
        foreach (self::$classmap as $key => $value) {
            if (!isset($options['classmap'][$key])) {
                $options['classmap'][$key] = $value;
            }
        }
        parent::__construct($wsdl, $options);
    }

    /**
     *
     *
     * @param GetReport $parameters
     * @return GetReportResponse
     */
    public function GetReport(GetReport $parameters) {
        return $this->__soapCall('GetReport', array($parameters), array(
            'uri' => 'http://schema.microbilt.com/messages/',
            'soapaction' => 'http://schema.microbilt.com/messages/GetReport'
        )
        );
    }

    /**
     *
     *
     * @param GetRawReport $parameters
     * @return GetRawReportResponse
     */
    public function GetRawReport(GetRawReport $parameters) {
        return $this->__soapCall('GetRawReport', array($parameters), array(
            'uri' => 'http://schema.microbilt.com/messages/',
            'soapaction' => 'http://schema.microbilt.com/messages/GetRawReport'
        )
        );
    }

    /**
     *
     *
     * @param GetArchiveReport $parameters
     * @return GetArchiveReportResponse
     */
    public function GetArchiveReport(GetArchiveReport $parameters) {
        return $this->__soapCall('GetArchiveReport', array($parameters), array(
            'uri' => 'http://schema.microbilt.com/messages/',
            'soapaction' => 'http://schema.microbilt.com/messages/GetArchiveReport'
        )
        );
    }


    function __doRequest($request, $location, $action, $version, $one_way=0) {
        //remove empty elements
        $dom = new DOMDocument('1.0');

        try {
            $dom->loadXML($request);
        } catch (DOMException $e) {
            die('Parse error with code ' . $e->code);
        }

        $elements = $dom->getElementsByTagName('Body');

        foreach ($elements as $element)
        {
            if ($element->parentNode->localName == "Envelope") {
                $children = $element->childNodes;
                foreach ($children as $child)
                    $this->clean_xml($child);
            }
        }

        $request = $dom->saveXML();

        return parent::__doRequest($request, $location, $action, $version, $one_way);
    }

    private $nodes;

    function clean_xml($node) {
        $this->traverse($node);
        if($this->nodes):
        foreach ($this->nodes as $nd)
        {
            $parent = $nd->parentNode;
            $oldnode = $parent->removeChild($nd);
        }
        endif;
    }


    function traverse(DomNode $node, $level = 0) {
        $this->handle_node($node, $level);
        if ($node->hasChildNodes()) {
            $children = $node->childNodes;
            foreach ($children as $kid) {
                if ($kid->nodeType == XML_ELEMENT_NODE) {
                    $this->traverse($kid, $level + 1);
                }
            }
        }
    }

    function handle_node(DomNode $node, $level) {
        if ($node->nodeType == XML_ELEMENT_NODE && $node->nodeValue == null)
            $this->nodes[] = $node;
    }

}

?>
