var mayday = mayday || {};

(function (mayday) {

    var Socket = function (timeout) {
        this.timeout = timeout;
        this.socket = null;
        this.listeners = {};
    };

    Socket.prototype = {

        register: function (event, callback) {
            this.listeners[event] = callback;
            return this;
        },

        connect: function (host, port) {
            if (!window.WebSocket) {
                alert('Your browser does not support web sockets.');
            }
            this.socket = new WebSocket('ws://' + host + ':' + port);
            //this.socket.onmessage = this.receive;
            this.socket.onmessage = function (message) { console.log(message); };
            this.socket.onerror = function () { console.log('error'); };
            this.socket.onopen = function () { console.log('open'); };
            this.socket.onclose = function () { console.log('close'); };
            return this;
        },

        receive: function (message) {
            var bits = message.data.split(':');
            var event = bits[0];
            var parameters = bits.length > 1 ? JSON.parse(bits[1]) : {};
            if (this.listeners[event]) this.listeners[event](parameters);
            return this;
        },

        ping: function (callback) {
            this.socket.onopen = function () { console.log('socket open !'); };
            //var timeout = setTimeout(function () { callback(false); }, this.timeout);
            //this.register('pong', function () { clearTimeout(timeout); callback(true); });
            //this.socket.send('ping');
            return this;
        }

    };

    mayday.Socket = Socket;

})(mayday);
