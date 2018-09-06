
<div class="right-head">
    <div class="title chatsession-title">DuckChat<sup style="font-size: 0.8rem; color: red;">抢先体验版</sup></sup> <SMALL style="font-size: 1rem;">单聊、群聊、小程序、高扩展，支持iOS、Android、Web，进QQ群咨询详情！开源！免费！</SMALL></div>
    <div class="actions">
        <img src="../../public/img/msg/invite_people.png"  class="invite_people"/>
        <img src="../../public/img/msg/add_friend.png"  class="add_friend add-friend-btn"/>
        <img src="../../public/img/msg/setting.png" class="see_group_profile"/>
    </div>
</div>

<div class="right-body">

    <div class="right-body-chat" style="position: relative;">
        <div class="right-chatbox">

        </div>

        <div id="emojies" style="display: none;position: absolute; bottom:13rem;">
            <div class="emoji-row" style="margin-top: 1rem;">
                <item class="emotion-item">🙂</item>
                <item  class="emotion-item">😂</item>
                <item  class="emotion-item">😊</item>
                <item  class="emotion-item">😉</item>
                <item  class="emotion-item">😋</item>
                <item  class="emotion-item">😎</item>
                <item  class="emotion-item">😀</item>
                <item  class="emotion-item">😍</item>
                <item  class="emotion-item">🤩</item>
            </div>
            <div class="emoji-row">
                    <item  class="emotion-item">😤</item>
                    <item  class="emotion-item" >😬</item>
                    <item class="emotion-item" >😡</item>
                    <item class="emotion-item">😠</item>
                    <item class="emotion-item">🙁</item>
                    <item class="emotion-item">😞</item>
                    <item class="emotion-item">😰</item>
                    <item class="emotion-item">😭</item>
                    <item class="emotion-item">😱</item>
                </div>

            <div class="emoji-row">
                <item  class="emotion-item">😘</item>
                <item  class="emotion-item">👄</item>
                <item  class="emotion-item">💋</item>
                <item  class="emotion-item">💘</item>
                <item  class="emotion-item">❤️</item>
                <item  class="emotion-item">💔</item>
                <item  class="emotion-item">🌹</item>
                <item  class="emotion-item">🥀</item>
                <item  class="emotion-item">😷</item>
            </div>

            <div class="emoji-row">
                <item  class="emotion-item">🙃</item>
                <item  class="emotion-item">🙄</item>
                <item  class="emotion-item">😴</item>
                <item  class="emotion-item">😓</item>
                <item  class="emotion-item">😳</item>
                <item  class="emotion-item">🤔</item>
                <item  class="emotion-item">😐</item>
                <item  class="emotion-item">🤫</item>
                <item  class="emotion-item">🤧</item>
            </div>

            <div class="emoji-row">
                <item  class="emotion-item">🤮</item>
                <item  class="emotion-item">🤪</item>
                <item  class="emotion-item">😇</item>
                <item  class="emotion-item">😏</item>
                <item  class="emotion-item">💀</item>
                <item  class="emotion-item">👻</item>
                <item  class="emotion-item">💩</item>
                <item  class="emotion-item">😝</item>
                <item  class="emotion-item">💪</item>
            </div>

            <div class="emoji-row">
                <item  class="emotion-item">✌</item>
                <item  class="emotion-item">👌</item>
                <item  class="emotion-item">👍</item>
                <item  class="emotion-item">👎</item>
                <item  class="emotion-item">✊</item>
                <item  class="emotion-item">👏</item>
                <item  class="emotion-item">🙏</item>
                <item  class="emotion-item">🍻</item>
                <item  class="emotion-item">👅</item>

            </div>
            <div class="emoji-row">
                <item  class="emotion-item">💢</item>
                <item  class="emotion-item">💣</item>
                <item  class="emotion-item">👙</item>
                <item  class="emotion-item">👑</item>
                <item  class="emotion-item">💍</item>
                <item  class="emotion-item">💎</item>
                <item  class="emotion-item">🌼</item>
                <item  class="emotion-item">💩</item>
                <item  class="emotion-item">💊</item>
            </div>
            <div class="emoji-row">
                <item  class="emotion-item">💰</item>
                <item  class="emotion-item">💳</item>
                <item  class="emotion-item">🐵</item>
                <item  class="emotion-item">🐶</item>
                <item  class="emotion-item">🦊</item>
                <item  class="emotion-item">🐱</item>
                <item  class="emotion-item">🐷</item>
            </div>
        </div>
        <div class="right-input">
            <div class="input-tools">
                <img src="../../public/img/msg/emotions.png" class="emotions"/>
                <img src="../../public/img/msg/images.png"  onclick="uploadFile('file1')" class="upload-img" accept="image/gif,image/jpeg,image/jpg,image/png,image/svg"/>
                <input type="file" id="file1" style="display:none" onchange="uploadMsgImgFromInput(this)" accept="image/gif,image/jpeg,image/jpg,image/png,image/svg">
            </div>

            <div class="input-box">
                <div id="msgImage">
                </div>
                <textarea class="input-box-text msg_content" placeholder="Type a message…." id="msg_content"></textarea>

                <div class="input-btn">
                    <button class="send_msg" data-local-value="sendTip">Send</button>
                </div>
            </div>
            <div class="input-line"></div>

        </div>
    </div>
    <div class="right-body-sidebar " style="display: none;">

        <div class="right-body-sidebar-menu">
            <img src="../../public/img/msg/btn-close.png" onclick="$('.right-body-sidebar').hide()" />
        </div>

        <div style="position: relative">
            <div class="group-profile-desc">
                <div class="group-desc">
                    <div class="group-desc-title" style="position: relative" data-local-value="groupProfileDescTip">
                        Group Introduce
                    </div>
                    <button class="save_group_introduce" style=" margin-top: -2rem;" data-local-value="saveGroupDescTip">Save</button>

                    <div class="group-desc-body">
                        <textarea class="group-introduce"></textarea>
                    </div>
                </div>

                <div class="action-group">
                    <div class="action-row action-row-disclosure edit_group_name">
                        <div class="action-title" data-local-value="groupProfileNameTip">Group Name</div>
                        <div class="action-btn groupName" style="width: auto;">

                        </div>
                        <img src="../../public/img/edit.png" style="width: 1rem; height:1rem; margin-right: 2rem;margin-top: 2rem;"/>
                    </div>

                    <div class="action-row action-row-disclosure remove_member">
                        <div class="action-title" data-local-value="removeGroupMemberTip">Remove Member</div>
                        <div class="action-btn">
                            <img src="../../public/img/msg/icon_disclosure.png" />
                        </div>
                    </div>

                    <div class="action-row mute-group">
                        <div class="action-title" data-local-value="muteTip">Mute</div>
                        <div class="action-btn ">
                            <img src="../../public/img/msg/icon_switch_off.png" class="group_mute" />
                        </div>
                    </div>

                    <div class="action-row permission-join" style="display: none"  >
                        <div class="action-title" data-local-value="joinGroupPermissionsTip">Join Group Permissions</div>
                    </div>

                    <div class="action-row can-guest-read-message" style="display: none"  >
                        <div class="action-title" data-local-value="canGuestReadMsgTip">Guest Can Read Msg</div>
                        <div class="action-btn ">
                            <img src="../../public/img/msg/icon_switch_off.png" class="can_guest_read_message" />
                        </div>
                    </div>

                    <div class="action-row share-group" >
                        <div class="action-title" data-local-value="shareGroupTip">Share Group Qrcode</div>
                    </div>

                    <div class="action-row quit-group" style="display: none;border-bottom: 1px solid rgba(223,223,223,1);" >
                        <div class="action-title" data-local-value="quitGroupTip">Quit Group</div>
                    </div>

                    <div class="action-row delete-group" style="display: none;border-bottom: 1px solid rgba(223,223,223,1);">
                        <div class="action-title" data-local-value="disbandGroupTip">Disband Group</div>
                    </div>
                </div>
            </div>

            <div class="user-profile-desc" style="position:absolute; visibility:hidden;">
                <div class="user-desc" >
                    <div style="text-align: center">
                        <img class="user-image-for-add " src="../../public/img/msg/default_user.png" style="width:7rem; height: 7rem; border-radius: 50%;">
                        <div class="user-desc-body">
                        </div>
                    </div>

                </div>

                <div class="action-user">
                    <div class="action-row action-row-disclosure edit-remark">
                        <div class="action-title" data-local-value="editRemarkTip">Edit Remark Name</div>
                        <div class="action-btn ">
                            <img src="../../public/img/msg/icon_disclosure.png" />
                        </div>
                    </div>

                    <div class="action-row mute-friend">
                        <div class="action-title" data-local-value="muteTip">Mute</div>
                        <div class="action-btn ">
                            <img src="../../public/img/msg/icon_switch_off.png" class="friend_mute" />
                        </div>
                    </div>

                    <div class="action-row delete-friend" style=" border-bottom: 1px solid rgba(223,223,223,1);">
                        <div class="action-title" data-local-value="deleteFriendTip">Delete Friend</div>
                    </div>

                    <div class="action-row add-friend add-friend-btn">
                        <div class="action-title"  data-local-value="addFriendTip">Add Friend</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



