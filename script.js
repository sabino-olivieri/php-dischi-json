const { createApp } = Vue;

const app = createApp({


    data() { //dati
        return {
            discList: [],
            linkApi: "http://localhost/boolean-php/php-dischi-json/server.php"
        }
    },
    methods: {
        toggleLike(curIndex) {
            
            const data = {
                action: "toggle-favorite",
                index: curIndex,
            };

            console.log(data);

            axios.post(this.linkApi, data, {
                headers: {
                    "Content-type": "multipart/form-data",
                },
            }).then((resp) => {
                this.discList = resp.data.response;
            });


        },

        saveDiscList() {
            const data = {
                newList: this.discList,
            };

            axios
                .post(
                    this.linkApi,
                    data,
                    {
                        headers: {
                            "Content-type": "multipart/form-data",
                        },
                    }
                )
                .then((resp) => {
                    this.discList = resp.data.response;
                });
        }
    },
    created() {
        axios.get('http://localhost/boolean-php/php-dischi-json/server.php').then((resp) => {
            this.discList = resp.data.response;
        })
    }
}).mount('#app');