const { createApp } = Vue;

const app = createApp({


    data() { //dati
        return {
            discList: [],
            linkApi: "http://localhost/boolean-php/php-dischi-json/server.php",
            filter: "filter-all"
        }
    },
    methods: {
        toggleLike(curIndex) {

            const data = {
                action: "toggle-favorite",
                index: curIndex,
                filter: this.filter,
            };

            console.log(data);

            axios.post(this.linkApi, data, {
                headers: {
                    "Content-type": "multipart/form-data",
                },
            }).then((resp) => {
                // this.discList = resp.data.response;
                this.discFilter();
            });


        },

        discFilter() {
            axios.get(this.linkApi, {
                params: {
                    filter: this.filter
                }
            }).then((resp) => {
                console.log(resp);
                this.discList = resp.data.response;
            });
        }
    },
    created() {
        this.discFilter();
    }
}).mount('#app');