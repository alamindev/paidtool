<template>
  <div class="chat--main-parent">
    <button class="chat--refresh" @click="refreshPage" type="button">
      Refresh
    </button>
    <div
      class="chat--message-box bg"
      v-chat-scroll="{ newData }"
      @scroll-top="loadNewData()"
    >
      <div class="chat--loader" v-if="loader">
        <div class="LoaderBalls">
          <div class="LoaderBalls__item"></div>
          <div class="LoaderBalls__item"></div>
          <div class="LoaderBalls__item"></div>
        </div>
      </div>
      <div
        class="chat--loop-area"
        v-for="message in getMessages"
        :key="message.id"
      >
        <div class="chat--message">
          <div class="chat--avater">
            <img src="/uploads/avatar.png" alt="avatar" width="50" />
          </div>
          <div>
            <div
              class="chat--text-main"
              :class="
                +message.user.role_id === 1 &&
                message.reply_user_name == message.user.name
                  ? 'chat--text-main-admin'
                  : ''
              "
            >
              <div class="chat--user">
                <h2
                  class="chat--user-text"
                  v-if="check_is_admin_reply(message)"
                >
                  {{ message.user.name }}
                </h2>
                <h2 class="chat--user-text" v-if="+message.user.role_id === 1">
                  {{ message.reply_user_name }}
                </h2>
              </div>
              <p class="chat--text">{{ message.text }}</p>
              <div class="chat--manage-bottom">
                <button
                  class="chat--manage-btn"
                  @click="replyMessage(message.id)"
                >
                  Reply
                </button>
                <button
                  v-if="is_admin"
                  class="chat--manage-btn"
                  @click="deleteMessage(message.id)"
                >
                  Delete
                </button>
              </div>
            </div>
            <ul
              style="margin: 0; padding-top: 10px"
              v-if="message.replies.length > 0"
            >
              <li v-for="reply in message.replies" :key="reply.id">
                <div
                  class="chat--message"
                  :class="
                    +reply.user.role_id === 1 ? 'chat--message-admin' : ''
                  "
                >
                  <div class="chat--avater">
                    <img src="/uploads/avatar.png" alt="avatar" width="50" />
                  </div>
                  <div class="chat--text-main">
                    <div class="chat--user">
                      <h2 class="chat--user-text">
                        {{ reply.user.name }}
                        <span class="chat--user-register"> Reply to </span>
                        <span v-if="+message.user.role_id === 1">
                          {{ message.reply_user_name }}</span
                        >
                        <span v-else> {{ message.user.name }}</span>
                      </h2>
                    </div>
                    <p class="chat--text">{{ reply.text }}</p>
                    <div class="chat--manage-bottom">
                      <button
                        style="display: none"
                        class="chat--manage-btn"
                        @click="replyMessage(reply.id)"
                      >
                        Reply
                      </button>
                      <button
                        v-if="is_admin"
                        class="chat--manage-btn"
                        @click="deleteMessage(reply.id)"
                      >
                        Delete
                      </button>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="chat--input-box">
      <div class="chat--input-main">
        <textarea-autosize
          ref="myTextarea"
          class="chat--input"
          v-model="message"
          :min-height="30"
          :max-height="200"
        />
      </div>
      <div class="chat--selectbox" v-if="is_admin">
        <multiselect
          v-model="user"
          id="ajax"
          label="name"
          track-by="name"
          placeholder="Type to search"
          :options="options"
          :multiple="false"
          :searchable="true"
          :loading="isLoading"
          :internal-search="false"
          :options-limit="300"
          :limit="3"
          :max-height="600"
          :show-no-results="false"
          @search-change="asyncFind"
        >
        </multiselect>
      </div>
      <button class="chat--send-btn" @click="sendMessage" :disabled="is_text">
        Send
      </button>
    </div>
    <modal
      name="dialog"
      class="relative"
      :clickToClose="false"
      :scrollable="true"
      :adaptive="true"
      height="auto"
    >
      <div @click="hidemodal" class="chat--modal-close">X</div>
      <div class="chat--modal-body">
        <div v-if="modal_user != null">
          <h3 class="chat--modal-reply">
            Reply To
            <span v-if="+modal_user.user.role_id !== 1">{{
              modal_user.user.name
            }}</span>
            <span v-if="+modal_user.user.role_id === 1">{{
              modal_user.reply_user_name
            }}</span>
          </h3>
          <p class="chat--modal-reply-text">
            Quote:
            <span style="white-space: pre-line">"{{ modal_user.text }}"</span>
          </p>
        </div>
        <div class="chat--input-box">
          <div class="chat--input-main">
            <textarea-autosize
              ref="myTextarea"
              class="chat--input"
              v-model="message_modal"
              :min-height="30"
              :max-height="200"
            />
          </div>
          <button
            class="chat--send-btn"
            @click="sendMessageFromModal"
            :disabled="is_text"
          >
            Reply
          </button>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
export default {
  name: "chat-component",
  props: ["user_id", "role"],
  data() {
    return {
      message: "",
      message_modal: "",
      is_text: true,
      messages: [],
      loader: false,
      user: null,
      options: [],
      is_admin: false,
      modal_user: null,
      isLoading: false,
      current_user_id: null,
      newData: false,
    };
  },
  watch: {
    message: function (newval, oldval) {
      if (this.is_admin) {
        if (newval.length > 1 && this.user != null) {
          this.is_text = false;
          this.newData = true;
        } else {
          this.is_text = true;
        }
      } else {
        if (newval.length > 1) {
          this.is_text = false;
          this.newData = true;
        } else {
          this.is_text = true;
        }
      }
    },
    user: function (newval, oldval) {
      if (this.message.length > 1 && newval != null) {
        this.is_text = false;
        this.newData = true;
      } else {
        this.is_text = true;
      }
    },
    message_modal: function (newval, oldval) {
      if (newval.length > 1) {
        this.is_text = false;
      } else {
        this.is_text = true;
      }
    },
  },
  computed: {
    getMessages() {
      return _.sortBy(this.messages, ["id"]);
    },
    check_is_admin_reply() {
      return (message) => {
        if (+message.user.role_id !== 1) {
          return true;
        }
      };
    },
  },
  methods: {
    sendMessage() {
      let data = {
        text: this.message,
        user_id: this.user_id,
        user_name: this.user != null ? this.user.name : null,
        reply_created_at: this.user != null ? this.user.created_at : null,
      };
      axios.post("/chat-room/store", data).then((res) => {
        if (res.data.success === true) {
          this.message = "";
          this.is_text = true;
          this.messages.unshift(res.data.data);
        }
      });
    },
    sendMessageFromModal() {
      let data = {
        text: this.message_modal,
        user_id: this.user_id,
        parent_id: this.message_id,
      };
      axios.post("/chat-room/reply/store", data).then((res) => {
        if (res.data.success === true) {
          this.message = "";
          this.message_modal = "";
          this.is_text = true;
          let messages = [...this.messages];

          this.messages = messages.map((el) => {
            if (el.id == res.data.data.parent_id) {
              el.replies.push(res.data.data);
            }
            return el;
          });
          this.$modal.hide("dialog");
        }
      });
    },
    getMessageData() {
      axios.get("/chat-room/get-data").then((res) => {
        if (res.data.success === true) {
          this.messages = res.data.data;
        }
      });
    },
    loadNewData() {
      let last_id = this.messages.length > 0 ? _.last(this.messages).id : null;
      this.loader = true;
      axios.post("/chat-room/load-user-message", { last_id }).then((res) => {
        if (res.data.success === true) {
          _.forEach(res.data.data, (value) => {
            this.messages.push(value);
            this.loader = false;
          });
        }
        this.loader = false;
      });
    },
    deleteMessage(id) {
      if (confirm("Are you sure you want to delete!")) {
        axios.get(`/chat-room/delete-message/${id}`).then((res) => {
          if (res.data.success === true) {
            let filtered = this.messages.filter(function (item) {
              return item.id != id;
            });
            this.messages = filtered;
          }
        });
      }
    },
    hidemodal() {
      this.$modal.hide("dialog");
      this.message = "";
      this.message_modal = "";
      this.is_text = true;
    },
    replyMessage(id) {
      this.modal_user = _.find(this.messages, { id: id });
      this.message_id = id;
      this.$modal.show("dialog");
    },
    asyncFind(query) {
      this.isLoading = true;
      axios.get(`/chat-room/load-user/${query}`).then((res) => {
        if (res.data.success === true) {
          this.options = res.data.data;
          this.isLoading = false;
        }
      });
    },
    refreshPage() {
      this.getMessageData();
    },
  },
  mounded() {
    this.scrollToLoad();
  },
  created() {
    this.getMessageData();
    if (+this.role === 1) {
      this.is_admin = true;
      axios.get(`/chat-room/load-user`).then((res) => {
        if (res.data.success === true) {
          this.options = res.data.data;
        }
      });
    } else {
      this.is_admin = false;
    }
    this.current_user_id = this.user_id;
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
textarea {
  resize: none;
}
.chat--refresh {
  border: 0 !important;
  margin-bottom: 10px !important;
  padding: 8px 20px !important;
  cursor: pointer;
  color: #000;
  background: #8bd1f8;
  border-radius: 5px;
}
.chat--refresh:focus,
.chat--refresh:hover {
  background: rgb(71, 185, 247);
}
.chat--loop-area {
  width: 100%;
}
.bg {
  background-color: #8bd1f8;
}
.chat--main-parent {
  margin-top: -15px;
}
.chat--avater {
  padding-right: 10px;
}
.chat--avater img {
  border-radius: 100%;
}
.chat--message {
  display: inline-flex;
  padding: 10px;
}
.chat--message-admin {
  display: inline-flex;
  padding: 10px;
}
.chat--message-admin .chat--text-main {
  background: #90ee90;
}
.chat--text-main-admin {
  background: #90ee90 !important;
}
.chat--user {
  padding-bottom: 8px;
  word-break: break-all;
}
.chat--user-text {
  font-size: 18px;
  font-weight: bold;
  text-transform: capitalize;
  margin: 0 !important;
}
.chat--user-register {
  color: #ff0000;
  font-weight: normal;
}
.chat--text-main {
  background-color: #fff;
  padding: 10px;
  border-radius: 10px;
}
.chat--text {
  font-size: 16px;
  font-weight: normal;
  margin: 0 !important;
  color: #000;
  white-space: pre-line;
}
.chat--message-box {
  height: 66vh;
  border-radius: 15px;
  padding: 10px;
  overflow-x: auto;
}

.chat--selectbox {
  width: 350px;
  padding-right: 10px;
}
.chat--input-box {
  padding-top: 20px;
  display: flex;
  align-items: center;
}
.chat--input-main {
  width: 100%;
  padding-right: 10px;
}
.chat--input {
  border: 1px solid #ccc !important;
  margin: 0 !important;
  border-radius: 10px !important;
  padding: 15px 15px !important;
  background: #fff !important;
  box-sizing: border-box !important;
}
.chat--input:focus {
  outline: 0 !important;
  box-shadow: none !important;
}
.chat--send-btn {
  background-color: #8bd1f8;
  color: #000000;
  font-weight: bold;
  border: none;
  padding: 25px 20px;
  width: 250px;
  border-radius: 10px;
  font-size: 18px;
  cursor: pointer;
}
.chat--send-btn:hover {
  background-color: #58c1fa;
}
.chat--send-btn:focus {
  background-color: #58c1fa !important;
}
.chat--send-btn:disabled,
.chat--send-btn[disabled] {
  background-color: #b8e6ff;
  cursor: not-allowed;
}
.chat--loader {
  padding: 10px 0;
  display: flex;
  justify-content: center;
  align-items: center;
}
.LoaderBalls {
  width: 60px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.LoaderBalls__item {
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background: #fff;
}
.LoaderBalls__item:nth-child(1) {
  animation: bouncing 0.4s alternate infinite
    cubic-bezier(0.6, 0.05, 0.15, 0.95);
}
.LoaderBalls__item:nth-child(2) {
  animation: bouncing 0.4s 0.1s alternate infinite
    cubic-bezier(0.6, 0.05, 0.15, 0.95) backwards;
}
.LoaderBalls__item:nth-child(3) {
  animation: bouncing 0.4s 0.2s alternate infinite
    cubic-bezier(0.6, 0.05, 0.15, 0.95) backwards;
}

@keyframes bouncing {
  0% {
    transform: translate3d(0, 6px, 0) scale(1.2, 0.85);
  }
  100% {
    transform: translate3d(0, -15px, 0) scale(0.9, 1.1);
  }
}
.multiselect__spinner::after,
.multiselect__spinner::before {
  margin: 2px 0 0 -8px !important;
}
.multiselect__tags {
  min-height: 65px !important;
}
.multiselect__placeholder {
  padding-top: 12px !important;
}
.multiselect__select {
  top: 15px !important;
}
.chat--manage-bottom {
  display: flex;
  justify-content: flex-end;
  padding-top: 5px;
}
.chat--manage-btn:first-child {
  margin-right: 5px;
  background-color: #8bd1f8;
}
.chat--manage-btn:first-child:hover,
.chat--manage-btn:first-child:focus {
  background-color: #5abef5;
}

.chat--manage-btn {
  font-size: 12px;
  padding: 2px 5px;
  border: none;
  color: white;
  background: red;
  cursor: pointer;
  border-radius: 5px;
}
.chat--manage-btn:hover,
.chat--manage-btn:focus {
  background: rgb(204, 9, 9);
}
.chat--modal-close {
  padding: 5px;
  display: inline-block;
  background: #a3a3a3;
  width: 26px;
  height: 27px;
  border-radius: 50px;
  color: white;
  font-size: 14px;
  text-align: center;
  position: absolute;
  right: 5px;
  top: 5px;
  cursor: pointer;
}
.multiselect__single {
  line-height: 45px !important;
}
.chat--modal-body {
  padding: 30px 15px;
}
.chat--modal-reply {
  padding-top: 10px;
  font-size: 18px;
  color: #000;
  font-weight: bold;
}
.chat--modal-reply span {
  color: #58c1fa;
}
@media (max-width: 600px) {
  .chat--input-main {
    padding-bottom: 10px;
  }
  .multiselect__tags {
    min-height: 50px !important;
  }
  .multiselect__placeholder {
    padding-top: 5px !important;
  }
  .multiselect__select {
    top: 6px !important;
  }
  .multiselect__single {
    line-height: 30px !important;
  }
  .chat--input-box {
    padding-top: 10px;
  }
  .chat--input-box {
    flex-direction: column;
  }
  .chat--message-box {
    height: 55vh;
  }
  .chat--input-main {
    padding-right: 0;
  }
  .chat--input {
    margin-right: 0px !important;
    height: 3.5rem !important;
  }

  .chat--selectbox {
    padding-right: 0px;
    width: 100%;
    padding-bottom: 10px;
  }
  .chat--send-btn {
    width: 100%;
  }
  .chat--send-btn {
    padding: 15px 20px;
  }
  .chat--message {
    display: flex;
    padding: 5px 0;
  }
  .chat--text-main {
    width: 100%;
  }
  .chat--user-text {
    font-size: 14px;
    font-weight: bold;
    text-transform: capitalize;
    margin: 0 !important;
  }
  .chat--user-register {
    color: #ff0000;
    font-size: 12px;
  }
  .chat--text-main {
    padding: 8px;
  }
  .chat--avater img {
    width: 25px;
  }
  .chat--avater {
    padding-right: 5px;
  }
  .chat--text {
    font-size: 14px;
  }
}
</style>
