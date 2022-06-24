<template>
    <div>
        <div>
            <b-navbar variant="light" type="light" fixed="top">
                <b-navbar-brand tag="h1" class="mb-0 chat-title">채팅</b-navbar-brand>
            </b-navbar>
        </div>
        <!-- users 지우고 in 옆에다 usersWithoutSelf -->
        <br><br><br>
        <b-list-group style="max-width: 750px;">
            <b-list-group-item class="d-flex align-items-center mpointer" v-for="(user, index) in users" :key="user.id" @click="updatedChatView(user.id)">
                <b-avatar variant="secondary" class="mr-3 my-avatar"></b-avatar>
                <span class="mr-auto">
                    <span class="u-name">{{ user.name }}</span> 
                    <span class="ms-time">{{ messages[index][0].time }}</span>
                    <div class="mcon">{{ messages[index][0].content }}</div> 
                </span>
            </b-list-group-item>
        </b-list-group>
    </div>
</template>

<script>
   export default {
       // props: {
        //     currentUser: {
        //         type:Number,
        //         required:true
        //     }
        // },


        // 계산해주는 애
        // computed: {
        //     usersWithoutSelf() { // 로그인 한 자신은 유저 리스트에 안뜨게
        //         return this.users.filter(user => {
        //             return user.id !== this.currentUser
        //         });
        //     }
        // },

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
            }
        },

        created() {
            // request를 보냄
            axios.get('/api/messages/chatList', {
                params: {
                    currentUserId: 1 // 임시 //this.currentUser
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
        }
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
        background : rgb(194, 194, 194);
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
</style>