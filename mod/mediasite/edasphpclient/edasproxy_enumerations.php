<?php


    namespace Sonicfoundry\EDAS;

    /**
     * Proxy classes for Mediasite External Data Access Service (Edas)
     * These proxy classes were generated based on the Mediasite 6.0 EDAS WSDL definition.
     * Constant representations of acceptable Enumeration values from the Edas service
     * Any call that expects these values should only use the members of the "enum" thusly:
     *      WeekDay::Friday
     * Using values not defined in these classes may not be accepted on the service endpoint and may cause errors
     * PHP Version 5.3
     *
     * @copyright  Copyright (c) 2013, Sonic Foundry
     * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
     * @version    6.1.7
     * @package    SonicFoundry.Mediasite.Edas.PHPProxy
     * @subpackage Enumerations
     * @author     Cori Schlegel <coris@sonicfoundry.com>
     *             This software is provided "AS IS" without a warranty of any kind.

     */

    /**
     * Proxy class for enum/string AnalyticsRequestType
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class AnalyticsRequestType
    {

        const Presentation = "Presentation";
        const User         = "User";
        const IPAddress    = "IPAddress";
        const Server       = "Server";

    }

    /**
     * Proxy class for enum/string WeekDay
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class WeekDay
    {

        const None             = "None";
        const Sunday           = "Sunday";
        const Monday           = "Monday";
        const Tuesday          = "Tuesday";
        const Wednesday        = "Wednesday";
        const Thursday         = "Thursday";
        const Friday           = "Friday";
        const Saturday         = "Saturday";
        const CustomDay        = "CustomDay";
        const CustomWeekDay    = "CustomWeekDay";
        const CustomWeekEndDay = "CustomWeekEndDay";

    }

    /**
     * Proxy class for enum/string MonthOfTheYear
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class MonthOfTheYear
    {

        const None      = "None";
        const January   = "January";
        const February  = "February";
        const March     = "March";
        const April     = "April";
        const May       = "May";
        const June      = "June";
        const July      = "July";
        const August    = "August";
        const September = "September";
        const October   = "October";
        const November  = "November";
        const December  = "December";

    }

    /**
     * Proxy class for enum/string RecurrencePattern
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class RecurrencePattern
    {

        const None    = "None";
        const Daily   = "Daily";
        const Weekly  = "Weekly";
        const Monthly = "Monthly";
        const Yearly  = "Yearly";

    }

    /**
     * Proxy class for enum/string RecurrencePatternType
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class RecurrencePatternType
    {

        const Simple = "Simple";
        const Long   = "Long";

    }

    /**
     * Proxy class for enum/string WeekOfTheMonth
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class WeekOfTheMonth
    {

        const None   = "None";
        const First  = "First";
        const Second = "Second";
        const Third  = "Third";
        const Fourth = "Fourth";
        const Last   = "Last";

    }

    /**
     * Proxy class for enum/string ScheduleTitleType
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class ScheduleTitleType
    {

        const None                       = "None";
        const ScheduleNameAndAirDate     = "ScheduleNameAndAirDate";
        const RecorderNameAndAirDateTime = "RecorderNameAndAirDateTime";
        const ScheduleNameAndNumber      = "ScheduleNameAndNumber";

    }

    /**
     * Proxy class for enum/string EncodingStreamType
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class EncodingStreamType
    {

        const None  = "None";
        const Audio = "Audio";
        const Video = "Video";

    }

    /**
     * Proxy class for enum/string FilterType
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class FilterType
    {

        const None        = "None";
        const AspectRatio = "AspectRatio";
        const FrameRate   = "FrameRate";

    }

    /**
     * Proxy class for enum/string ResourcePermissionMask
     * Must be passed to Edas as a single value or as an array; bitwise and/or will not work
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class ResourcePermissionMask
    {

        const None         = "None";
        const Read         = "Read";
        const Write        = "Write";
        const Execute      = "Execute";
        const Moderate     = "Moderate";
        const Approve      = "Approve";
        const DenyRead     = "DenyRead";
        const DenyWrite    = "DenyWrite";
        const DenyExecute  = "DenyExecute";
        const DenyModerate = "DenyModerate";
        const DenyApprove  = "DenyApprove";

    }

    /**
     * Proxy class for enum/string PresentationDataStatusDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
class PresentationDataStatusDetails
{

    const None                = "None";
    const Scheduled           = "Scheduled";
    const OpenForRecord       = "OpenForRecord";
    const Recording           = "Recording";
    const Recorded            = "Recorded";
    const Uploaded            = "Uploaded";
    const TranscodingRequired = "TranscodingRequired";
    const LockedForUpdate     = "LockedForUpdate";

}

/**
     * Proxy class for enum/string ContentServerQueryBy
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class ContentServerQueryBy
    {

        const Presentation = "Presentation";
        const ServerType   = "ServerType";

    }

    /**
     * Proxy class for enum/string ResourceType
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class ResourceType
    {

        const Presentation            = "Presentation";
        const ContentEncodingSettings = "ContentEncodingSettings";
        const ContentServer           = "ContentServer";
        const Presenter               = "Presenter";
        const Player                  = "Player";
        const PresentationTemplate    = "PresentationTemplate";
        const SystemOperation         = "SystemOperation";
        const PortalResource          = "PortalResource";
        const Folder                  = "Folder";
        const Operation               = "Operation";
        const Recorder                = "Recorder";
        const MediaImportProject      = "MediaImportProject";

    }

    /**
     * Proxy class for string QueryScheduleBy
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class QueryScheduleBy
    {

        const All                     = "All";
        const ScheduledId             = "ScheduleId";
        const RecorderPhysicalAddress = "RecorderPhysicalAddress";
        const Key                     = "Key";

    }

    /**
     * Proxy class for enum/string SupportedSearchField
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class SupportedSearchField
    {

        const Name        = "Name";
        const Owner       = "Owner";
        const Description = "Description";
        const Presenter   = "Presenter";

    }

    /**
     * Proxy class for enum/string SupportedSearchType
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class SupportedSearchType
    {

        const Player                  = "Player";
        const PresentationTemplate    = "PresentationTemplate";
        const Folder                  = "Folder";
        const Recorder                = "Recorder";
        const RecorderSchedule        = "RecorderSchedule";
        const Presentation            = "Presentation";
        const Report                  = "Report";
        const Catalog                 = "Catalog";
        const ContentEncodingSettings = "ContentEncodingSettings";
        const ContentServer           = "ContentServer";

    }

    /**
     * Proxy class for enum/string DataServiceFaultType
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class DataServiceFaultType
    {

        const Unknown          = "Unknown";
        const BadRequest       = "BadRequest";
        const InvalidTicket    = "InvalidTicket";
        const ResourceNotFound = "ResourceNotFound";
        const Authentication   = "Authentication";
        const Authorization    = "Authorization";
        const ResourceExists   = "ResourceExists";
        const ResourceInUse    = "ResourceInUse";
        const ResourceError    = "ResourceError";
        const TicketNotFound   = "TicketNotFound";
        const TicketExpired    = "TicketExpired";
        const TicketError      = "TicketError";
        const InstallError     = "InstallError";
        const Configuration    = "Configuration";

    }

    /**
     * Proxy class for enum/string PresentationContentTypeDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class PresentationContentTypeDetails
    {

        const None                  = "None";
        const Slides                = "Slides";
        const Chapters              = "Chapters";
        const ExternalsLinks        = "ExternalLinks";
        const PresentationThumbnail = "PresentationThumbnail";
        const CaptionFile           = "CaptionFile";
        const OnDemandFile          = "OnDemandFile";
        const BroadcastStream       = "BroadcastStream";
        const PublishToGo           = "PublishToGo";

    }

    /**
     * Generated data proxy class for enum/string ContentServerEndpointType
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class ContentServerEndpointType
    {

        const Unknown         = "Unknown";
        const Distribution    = "Distribution";
        const Storage         = "Storage";
        const Broadcast       = "Broadcast";
        const WebService      = "WebService";
        const Local           = "Local";
        const UnicastRollover = "UnicastRollover";
        const Push            = "Push";

    }

    /**
     * Generated data proxy class for enum/string ContentServerTypeDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class ContentServerTypeDetails
    {

        const Unknown                = "Unknown";
        const MediasiteData          = "MediasiteData";
        const SlideServer            = "SlideServer";
        const PublishToGoServer      = "PublishToGoServer";
        const WmsOnDemandServer      = "WmsOnDemandServer";
        const WmsUnicastPullServer   = "WmsUnicastPullServer";
        const WmsMulticastPullServer = "WmsMulticastPullServer";
        const WmsUnicastPushServer   = "WmsUnicastPushServer";
        const CustomPullServer       = "CustomPullServer";
        const CustomPushServer       = "CustomPushServer";
        const IIsProgressiveServer   = "IIsProgressiveServer";
        const IIsMediaPushServer     = "IIsMediaPushServer";
        const IIsMediaOnDemandServer = "IIsMediaOnDemandServer";
        const IIsMediaPullServer     = "IIsMediaPullServer";

    }

    /**
     * Generated data proxy class for enum/string PresentationContentStatusDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class PresentationContentStatusDetails
    {

        const Unknown                 = "Unknown";
        const Pending                 = "Pending";
        const Working                 = "Working";
        const Completed               = "Completed";
        const Error                   = "Error";
        const Canceled                = "Canceled";
        const PendingManualCompletion = "PendingManualCompletion";

    }

    /**
     * Data proxy class for enum/string JobStatus
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class JobStatus
    {
        const Successful = "Successful";
        const Queued     = "Queued";
        const Working    = "Working";
        const Disabled   = "Disabled";
        const Failed     = "Failed";
        const Canceled   = "Canceled";
    }

    /**
     * Data proxy class for enum/string PublishingOptions
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class PublishingOptions
    {

        const AutoPublishViewable   = "AutoPublishViewable";
        const AutoUploadOffline     = "AutoUploadOffline";
        const ManualPublishViewable = "ManualPublishViewable";
        const ManualUploadOffline   = "ManualUploadOffline";

    }

    /**
     * Data proxy class for enum/string EntityApprovalStateDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class EntityApprovalStateDetails
    {

        const Unknown         = "Unknown";
        const ReviewRequired  = "ReviewRequired";
        const ChangesRequired = "ChangeRequired";
        const Approved        = "Approved";

    }

    /**
     * Data proxy class for enum/string EntityChangeTypesDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class EntityChangeTypesDetails
    {
        const None                       = "None";
        const DefaultApprovalChanges     = "DefaultApprovalChanges";
        const DefaultNotificationChanges = "DefaultNotificationCanges";
    }

    /**
     * Data proxy class for enum/string EntityChangeTypesDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class LogLevel
    {
        const Emergency     = "Emergency";
        const Alert         = "Alert";
        const Critical      = "Critical";
        const Error         = "Error";
        const Warning       = "Warning";
        const Notice        = "Notice";
        const Informational = "Informational";
        const Debug         = "Debug";
    }

    /**
     * Class CreateFolderTypeDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.7
     */
    class CreateFolderTypeDetails
    {
        const None   = "None";
        const Shared = "Shared";
    }
/**
 * Proxy class for enum/string ContentImportProjectItemStatusDetails
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
 * @since 6.1.11
 */
class ContentImportProjectItemStatusDetails
{
        const Unknown    = "Unknown";
        const NotStarted = "NotStarted";
        const InProgress = "InProgress";
        const Complete   = "Complete";
        const Error      = "Error";
}

	/**
	* Proxy class for enum/string ViewingSessionType
	*
	* @package SonicFoundry.Mediasite.Edas.PHPProxy
	* @referenceonly This class provided for reference only, client applications should never need to instantiate this class
	* @since 6.1.11
	*/
	class ViewingSessionType
	{
		const Live     = "Live";
		const OnDemand = "OnDemand";
	}
