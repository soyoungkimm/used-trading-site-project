<template>
    <b-col v-if="chatWith">
        <br><br><br>
        <b-row>
            <div>
                <b-navbar variant="light" type="light" fixed="top">
                    <b-navbar-brand tag="h1" class="mb-0 user-name">{{ current_chatting_user }}</b-navbar-brand>
                    <b-collapse id="nav-text-collapse" is-nav>
                        <b-navbar-nav>
                            <b-nav-text @click="backBtn()" class="mpoint">back</b-nav-text>
                        </b-navbar-nav>
                    </b-collapse>
                </b-navbar>
            </div>
        </b-row>
        <b-row>
            <div class="aaa">
                <ChatMessage v-for="message in messages" :key="message.id" :message="message" />
            </div>
        </b-row>
        <br><br><br>
        <b-navbar variant="light" type="light" fixed="bottom">
            <b-input-group>
                <b-form-input class="ms-input" type="text" v-model="message_content" @keyup.enter="submit"></b-form-input>
                <b-input-group-append>
                    <b-button variant="success" @click="submit">전송</b-button> 
                </b-input-group-append>
            </b-input-group>
        </b-navbar>
    </b-col>
    <b-col v-else>
         채팅 상대를 선택해주세요 
    </b-col>
</template>

<script>
    import ChatMessage from "./ChatMessage";
    
    export default {
        props: {
            chatWith: Number,
            messages: {
                type:Array,
                required: true
            }
        },
        data() {
            return {
                message_content: "",
                current_chatting_user : ""
            };
        },
        methods: {
            submit() {
                if (this.message_content) { // 텍스트가 있을 때만
                    axios.post("/api/messages", {
                        content: this.message_content,
                        to_user: this.chatWith,
                        from_user: 1 // 임시 this.currentUser
                    }).then(res => {
                        this.messages.push(res.data.message);
                    });
                    this.message_content = ""; // 메시지 칸 지우기
                }
            },

            backBtn() {
                this.$emit('back');
            }
        },
        components: { 
            ChatMessage
        },
        created(){
            axios.get("/api/messages/getUserName", {
                params: {
                    chatWith : this.chatWith
                }
                
            }).then(res => {
                this.current_chatting_user = res.data.name[0].name;
            });

        }
    }
</script>

<style>
    .user-name {
        margin-left : 20px;
        font-weight: 600;
    }

    .mpoint {
        cursor : pointer;
    }

    .ms-input {
        margin-left : 10px;
        margin-right : 10px;
    }
</style>