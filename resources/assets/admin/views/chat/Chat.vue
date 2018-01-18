<template>
    <div>
        <p v-if="isConnected">We're connected to the server!</p>
        <p>Message from server: "{{socketMessage}}"</p>
        <p>Clint send message: {{ dataClient }}</p>
        <input type="text" v-model="inputMessage">
        <button @click="pingServer()">Ping Server</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isConnected: false,
            socketMessage: '',
            dataClient: '',
            inputMessage: ''
        }
    },

    sockets: {
        connect() {
            // Fired when the socket connects.
            this.isConnected = true;
        },

        disconnect() {
            this.isConnected = false;
        },

        // Fired when the server sends something on the "messageChannel" channel.
        pingServer(data) {
            this.socketMessage = data
        }
    },

    methods: {
        pingServer() {
            // Send the "pingServer" event to the server.
            console.log(this.inputMessage)
            this.$socket.emit('pingServer', this.inputMessage)
        }
    }
}
</script>