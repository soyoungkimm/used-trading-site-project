<template>
    <b-container class="bv-example-row">
        <!-- chatWith 값이 있으면 -->
        <b-row> 
            <div v-if="!chatWith">
                <ChatUserList @update-chat-view="updateChatView" :chat-with="chatWith"  />
            </div>
             <!-- :current-user="currentUser"  -->
            <div v-if="chatWith">
                <ChatArea v-bind:chatWith="chatWith" @back="back" :messages="messages"/>
            </div>
        </b-row>
    </b-container>
</template>

<script>
    import ChatUserList from './ChatUserList';
    import ChatArea from './ChatArea';
    export default {
        // props: {
        //     currentUser: {
        //         type:Number,
        //         required:true
        //     }
        // },
        data() {
            return {
                chatWith: null,
                messages : []
            }
        },

        components: { 
            ChatUserList,
            ChatArea
        }, 
        
        methods: {
            updateChatView(value) {
                
                this.chatWith = value;
                this.getMessages();


            },

            getMessages() {
                axios.get('/api/messages', {
                    params: {
                        chatWith: this.chatWith,
                        currentUser: 1 // 임시 //this.currentUser
                    }
                }).then(res => {
                    //console.log(res);
                    this.messages = res.data.messages;
                }).catch(error => { // 예외처리
                    console.log(error);
                });
            },

            back() {
                this.chatWith = null;
            }
        },

        created() {
            // 이벤트 듣기
            window.Echo.channel('my-channel')// Echo.private
                .listen('MyEvent', (e) => {
                    //console.log(this.chatWith);
                    //if(e.message.to_user == this.currentUser && e.message.from_user == this.chatWith) 임시 - 나중에 로그인 완성되면 풀기. 현재 채팅하고 있는 상대에게만 메세지 보이게 하기
                    this.messages.push(e.message);
                }); 
        },

        mounted() {
            // 연락하기 눌렀을 때 바로 상점 주인한테 채팅할 수 있게 함
            this.chatWith = parseInt(document.getElementById("b_parrent_chatWith").value);
            if (this.chatWith != null) {
                this.updateChatView(this.chatWith);
            }
        }
    }
</script>

<style>
    
</style>