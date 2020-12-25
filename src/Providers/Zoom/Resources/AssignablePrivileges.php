<?php

namespace Nncodes\Meeting\Providers\Zoom\Resources;

class AssignablePrivileges
{
    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST USER_READ = "User:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST USER_EDIT = "User:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ROLE_READ = "Role:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ROLE_EDIT = "Role:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST GROUP_READ = "Group:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST GROUP_EDIT = "Group:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ACCOUNT_PROFILE_READ = "AccountProfile:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ACCOUNT_PROFILE_EDIT = "AccountProfile:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ACCOUNT_SETTING_READ = "AccountSetting:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ACCOUNT_SETTING_EDIT = "AccountSetting:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST WEBINAR_SETTING_READ = "WebinarSetting:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST WEBINAR_SETTING_EDIT = "WebinarSetting:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST RECORDING_READ = "Recording:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST RECORDING_EDIT = "Recording:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST RECORDING_CONTENT_READ = "RecordingContent:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST SUB_ACCOUNT_READ = "SubAccount:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST SUB_ACCOUNT_EDIT = "SubAccount:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST CALL_IN_CONTACTS_READ = "CallInContacts:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST CALL_IN_CONTACTS_EDIT = "CallInContacts:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ZOOM_ROOMS_READ = "ZoomRooms:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ZOOM_ROOMS_EDIT = "ZoomRooms:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST IM_CHAT_HISTORY_READ = "IMChatHistory:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST IM_GROUPS_READ = "IMGroups:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST IM_GROUPS_EDIT = "IMGroups:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST IM_SETTING_READ = "IMSetting:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST IM_SETTING_EDIT = "IMSetting:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST BILLING_SUBSCRIPTION_READ = "BillingSubscription:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST BILLING_SUBSCRIPTION_EDIT = "BillingSubscription:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST BILLING_INFORMATION_READ = "BillingInformation:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST BILLING_INFORMATION_EDIT = "BillingInformation:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST USAGE_REPORT_READ = "UsageReport:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST USER_ACTIVITIES_REPORT_READ = "UserActivitiesReport:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST SCHEDULE_TRACKING_FIELDS_READ = "ScheduleTrackingFields:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST SCHEDULE_TRACKING_FIELDS_EDIT = "ScheduleTrackingFields:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ZOOM_DEVELOPERS_READ = "ZoomDevelopers:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ZOOM_DEVELOPERS_EDIT = "ZoomDevelopers:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ROOM_CONNECTOR_READ = "RoomConnector:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST ROOM_CONNECTOR_EDIT = "RoomConnector:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST MEETING_CONNECTOR_READ = "MeetingConnector:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST MEETING_CONNECTOR_EDIT = "MeetingConnector:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST LYNC_CONNECTOR_READ = "LyncConnector:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST LYNC_CONNECTOR_EDIT = "LyncConnector:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST THIRD_PARTY_CONFERENCE_READ = "ThirdPartyConference:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST THIRD_PARTY_CONFERENCE_EDIT = "ThirdPartyConference:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST BRANDING_READ = "Branding:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST BRANDING_EDIT = "Branding:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST SINGLE_SIGN_ON_READ = "SingleSignOn:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST SINGLE_SIGN_ON_EDIT = "SingleSignOn:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST INTEGRATION_READ = "Integration:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST INTEGRATION_EDIT = "Integration:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST MEETING_EDIT = "Meeting:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST MEETING_JOIN = "Meeting:Join";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST SIP_PHONE_READ = "SipPhone:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST SIP_PHONE_EDIT = "SipPhone:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST CROSS_HYBRID_READ = "CrossHybrid:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST CROSS_HYBRID_EDIT = "CrossHybrid:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST SECURITY_READ = "Security:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST SECURITY_EDIT = "Security:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DIGITAL_SIGNAGE_READ = "DigitalSignage:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DIGITAL_SIGNAGE_EDIT = "DigitalSignage:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST MARKET_PLACE_READ = "MarketPlace:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST MARKET_PLACE_EDIT = "MarketPlace:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST PBX_ADMIN_READ = "PbxAdmin:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST PBX_ADMIN_EDIT = "PbxAdmin:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST IM_CHAT_BOT_EDIT = "IMChatBot:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST MOBILE_DEVICE_MANAGEMENT_READ = "MobileDeviceManagement:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST MOBILE_DEVICE_MANAGEMENT_EDIT = "MobileDeviceManagement:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST CALENDAR_INTEGRATION_READ = "CalendarIntegration:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST CALENDAR_INTEGRATION_EDIT = "CalendarIntegration:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DASHBOARD_HOME_READ = "DashboardHome:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DASHBOARD_MEETINGS_READ = "DashboardMeetings:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DASHBOARD_MEETING_JOIN_EDIT = "DashboardMeetingJoin:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DASHBOARD_MEETING_CONTROL_EDIT = "DashboardMeetingControl:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DASHBOARD_MEETING_END_EDIT = "DashboardMeetingEnd:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DASHBOARD_ZR_READ = "DashboardZR:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DASHBOARD_CRC_READ = "DashboardCRC:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DASHBOARD_WEBINARS_READ = "DashboardWebinars:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DASHBOARD_WEBINAR_JOIN_EDIT = "DashboardWebinarJoin:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DASHBOARD_IM_READ = "DashboardIM:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST DASHBOARD_PBX_READ = "DashboardPBX:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST USER_ADVANCED_READ = "UserAdvanced:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST USER_ADVANCED_EDIT = "UserAdvanced:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST CHAT_MESSAGE_READ = "ChatMessage:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST CHAT_MESSAGE_EDIT = "ChatMessage:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST CHAT_CHANNEL_READ = "ChatChannel:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST INFORMATIONBARRIERS_READ = "Informationbarriers:Read";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST INFORMATIONBARRIERS_EDIT = "Informationbarriers:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST CHAT_CHANNEL_EDIT = "ChatChannel:Edit";

    /**
    * View user information, including the assignment of users to roles.
    * @var string
    */
    CONST NEW_IM_CHAT_HISTORY_READ = "NewIMChatHistory:Read";
}
