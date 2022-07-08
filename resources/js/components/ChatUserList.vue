<template>
    <div>
        <div>
            <b-navbar variant="light" type="light" fixed="top">
                <b-navbar-brand tag="h1" class="mb-0 chat-title">채팅</b-navbar-brand>
            </b-navbar>
        </div>
        <!-- users 지우고 in 옆에다 usersWithoutSelf -->
        <br><br><br>
        <b-list-group v-if="users.length != 0" style="max-width: 750px;">
            <b-list-group-item class="d-flex align-items-center mpointer" v-for="(user, index) in users" :key="user.id" @click="updatedChatView(user.id)">
                <b-avatar class="mr-3 my-avatar" variant="info" :src="getImage(user.image)" size="3em"></b-avatar>
                <span class="mr-auto">
                    <span class="u-name">{{ user.name }}</span> 
                    <span class="ms-time">{{ messages[index][0].time }}</span>
                    <div class="mcon">{{ messages[index][0].content }}</div> 
                </span>
            </b-list-group-item>
        </b-list-group>
        <div v-else id="dontHave">
            <br>
            채팅 상대가 없습니다
        </div>
    </div>
</template>

<script>
   export default {

        data() {
            return {
                users : [],
                messages : []
            }
        },

        props: {
            chatWith: {
                type:Number,
                required: false // 필수는 아님 null이 들어갈 수도 있으니까
            },
            currentUser: {
                type:Number,
                required:true
            }
        },

        created() {
            // request를 보냄
            axios.get('/api/messages/chatList', {
                params: {
                    currentUserId: this.currentUser
                }
            }).then(res => { // 받아옴. 받아온 값 res 안에 있음
                this.users = res.data.data.users;
                this.messages = res.data.data.messages;
            }).catch(error => { // 예외처리
                console.log(error);
            });
        },

        methods: {
            updatedChatView(userId) {
                this.$emit('update-chat-view', userId);
            },
            getImage(image) {
                if (image == null) {
                    image = "noProfile.png";
                }
                return window.location.protocol + "//" + window.location.host + "/storage/images/users/" + image;
            }
        },
    }
</script>

<style>
    .mpointer {
        cursor: pointer;
    }

    .mpointer:hover{
        background : rgb(235, 235, 235);
    }

    .my-avatar { 
        margin-right : 20px;
    }

    .chat-title {
        font-size : 20pt;
        margin-left : 20px;
    }

    .ms-time {
        font-size : 10pt;
        color : rgb(155, 155, 155);
    }

    .u-name {
        font-weight: 600;
    }

    .mcon {
        width: 350px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #dontHave {
        text-align: center;
        color : rgb(137, 137, 137);
    }
</style>