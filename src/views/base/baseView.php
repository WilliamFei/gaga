
<div class="wrapper-mask" id="wrapper-mask"></div>
<div class="wrapper" id="wrapper" >
    <div class="layout-left" >
        <div class="left-sidebar" style="position: relative;">
                <div>
                    <div class="l-sb-item" style="border: none;" >
                        <img class="useravatar selfInfo info-avatar-<?php echo $user_id;?>"  src="../../public/img/msg/default_user.png" style="background-color: #c9c9c9;" />
                    </div>
                    <div class="hint--right" style="width: 7.5rem;" aria-label="Message" data-local="aria-label:chatSessionTip">
                        <div class="l-sb-item l-sb-item-active" data="chatSession" >
                            <img src="../../public/img/msg/chatsession.png" data="select" class="chatSession-select item-img "/>
                            <img src="../../public/img/msg/chatsession_unselect.png" data="unselect" class="chatSession-unselect  item-img" style="display: none;"/>
                            <div style="display: none" class="room-list-msg-unread unread-num"></div>
                            <div style="display: none"  class="room-list-msg-unread-mute unread-num-mute"></div>
                        </div>
                    </div>

                    <div class=" hint--right" style="width: 7.5rem;" aria-label="Groups" data-local="aria-label:groupTip">
                        <div class="l-sb-item "  data="group" >
                            <img src="../../public/img/msg/group_chat_unselect.png" data="unselect" class="group-unselect item-img" />
                            <img src="../../public/img/msg/group_chat.png" data="select" class="group-select item-img" style="display: none;"/>
                        </div>
                    </div>
                    <div class=" hint--right" style="width: 7.5rem;" aria-label="Friends" data-local="aria-label:friendTip">
                        <div class="l-sb-item "  data="friend" >
                            <img src="../../public/img/msg/friend_unselect.png" data="unselect" class="friend-unselect item-img" />
                            <img src="../../public/img/msg/friend.png" data="select" class="friend-select item-img" style="display: none;"/>
                            <div style="display: none" class="apply-friend-list apply_friend_list_num" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="preemptiveVersionDiv">
                        <img class='preemptive_version' src="../../public/img/preemptive_version.png"/>
                    </div>
                    <div class="appDownload" style="display: none;">
                        <img class='app_download' src="../../public/img/dowload.png"/>
                    </div>
                </div>
        </div>

        <div class="left-body">
            <div class="left-body-container">
                <div class="left-body-chatsession chatsession-lists" style="position: relative;">
                </div>

                <div class="left-body-chatsession group-lists"  style="display: none;position: relative;">

                </div>
                <div class="left-body-chatsession friend-lists" style="display: none;position: relative;">

                </div>
                <div class="left-body-create-group">
                    <button class="create-group-btn" data-local-value="createGroupTip">Create Group</button>
                </div>
            </div>

        </div>
    </div>

