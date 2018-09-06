

//TODO domain 拆出去

var ZalyAction = {

    action_url : "./index.php?action=ActionName&body_format=json",

    api_group_create : "site.ApiGroupCreateRequest",
    api_site_config  : "site.ApiSiteConfigRequest",
    api_friend_list  : "site.ApiFriendListRequest",
    api_group_list   : "site.ApiGroupListRequest",
    api_group_invite :"site.ApiGroupInviteRequest",
    api_group_profile : "site.ApiGroupProfileRequest",
    api_group_invitableFriends : "site.ApiGroupInvitableFriendsRequest",
    api_group_removeMember : "site.ApiGroupRemoveMemberRequest",
    api_group_quit: "site.ApiGroupQuitRequest",
    api_group_update : "site.ApiGroupUpdateRequest",
    api_group_delete : "site.ApiGroupDeleteRequest",
    api_group_members :"site.ApiGroupMembersRequest",

    api_friend_update:"site.ApiFriendUpdateRequest",
    api_friend_apply : "site.ApiFriendApplyRequest",
    api_friend_applyList : "site.ApiFriendApplyListRequest",
    api_friend_accept : "site.ApiFriendAcceptRequest",
    api_friend_profile:"site.ApiFriendProfileRequest",
    api_friend_delete:"site.ApiFriendDeleteRequest",

    api_user_profile:"site.ApiUserProfileRequest",
    api_user_update:"site.ApiUserUpdateRequest",

    im_cts_message:"site.ImCtsMessageRequest",
    im_cts_sync : "site.ImCtsSyncRequest",
    im_cts_auth : "site.ImCtsAuthRequest",
    im_cts_updatePointer : "site.ImCtsUpdatePointerRequest",

    api_passport_passwordReg : "site.ApiPassportPasswordRegRequest",
    api_passport_passwordLogin : "site.ApiPassportPasswordLoginRequest",
    api_passport_passwordFindPassword :"site.ApiPassportPasswordFindPasswordRequest",
    api_passport_passwordResetPassword :"site.ApiPassportPasswordResetPasswordRequest",
    duckchat_message_send : "plugin.DuckChatMessageSendRequest",

    im_stc_news :"im.stc.news",
    im_stc_message_key :"im.stc.message",

    getReqeustName : function (action) {
        var action = action.split(".").join("_");
        return ZalyAction[action];
    },

    getRequestUrl : function(action) {
        var actionUrl = ZalyAction["action_url"];
        actionUrl = actionUrl.replace("ActionName", action);
        return actionUrl;
    }
}

