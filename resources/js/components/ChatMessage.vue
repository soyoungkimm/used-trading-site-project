<template>
    <div>
        <div class="dd">
            <b-badge class="mbadge">{{ getDate }}</b-badge>
        </div>
        <div v-if="message.from_user === currentUser">
            <b-row class="chat-row">
                <b-col class="align-right">
                    <br>
                    <span class="mess-time">{{ getTime }}</span> 
                    <span class="chat-content">{{ message.content }}</span> 
                </b-col>
            </b-row>
        </div>
        <div v-else>
            <b-row class="chat-row">
                <br><br><br>
                <b-col cols="2" class="align-right">
                    <b-avatar class="mr-3" variant="info" :src="getImage" size="3em"></b-avatar>
                </b-col>
                <b-col>
                    <div class="chat-u-name">{{ message.user_name }}</div>
                    <div class="chat-content">{{ message.content }}</div> 
                    <span class="mess-time">{{ getTime }}</span>
                </b-col>
            </b-row>
        </div>
    </div>
    
</template> 

<script>

    export default {
        props: {
            message: {
                type:Object,
                required: true
            },
            currentUser: {
                type:Number,
                required:true
            }
        },
        
        data() {
            return {
                users : [],
                messages : [],
            }
        },

        computed: {
            getDate: function() {
                let date = this.message.time.split('-')[0];
                return date;
            },

            getTime: function() {
                return this.message.time.split('-')[1];
            },

            getImage: function() {
                if (this.message.user_image == null) {
                    return window.location.protocol + "//" + window.location.host + "/storage/images/users/noProfile.png";
                }
                return window.location.protocol + "//" + window.location.host + "/storage/images/users/" + this.message.user_image;
            }
        },

        mounted() {
            // 중복되는 연월일 삭제
            let arr = document.getElementsByClassName("mbadge");
            for (let i = 0; i < arr.length; i++) {
                if (i != 0) {
                    if (arr[i-1].innerHTML === arr[i].innerHTML) {
                        arr[i].remove();
                    }
                }
            }

            // 스크롤 맨 아래로 내리기
            let objDiv = document.getElementById("app");
            window.scrollTo(0,objDiv.scrollHeight);
        }
    }

    
</script>

<style>
    .my-align {
        text-align: right;
    }

    .chat-avatar { 
        background : rgb(194, 194, 194);
        text-align : right
    }

    .align-right {
        text-align : right;
    }

    .chat-row {
        margin-top : 5px;
        margin-bottom : 5px;
    }

    .mess-time {
        font-size : 8pt;
        color : rgb(155, 155, 155);
    }

    .chat-u-name { 
        font-size : 11pt;
        margin-bottom : 5px;
    }

    .chat-content {
        background : #fff;
        border-radius : 5px;
        padding : 5px 7px 5px 7px;
        max-width : 200px;
        width : auto;
        display:inline-block;
        text-align: left;
    }

    .mbadge {
        background : rgb(224, 224, 224);
        border : solid 1px rgb(195, 195, 195);
        width : 300px;
        height : 20px;
        color : #000;
        margin-bottom: 10px;
        margin-top : 10px;
    }

    .dd {
        text-align : center;
    }
</style>