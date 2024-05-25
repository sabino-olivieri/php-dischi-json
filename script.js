const { createApp } = Vue;

const app = createApp({


    data() { //dati
        return {
            discList: [],
            linkApi: "http://localhost/boolean-php/php-dischi-json/backend/server.php",
            filter: "filter-all",
            formHidden: true,
            title: "",
            author: "",
            year: "",
            poster: "",
            genre: "",
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
        },

        addDisc() {
            this.closeForm();
            
            const data = {
                action: "add-disc",
                title: this.title,
                author: this.author,
                year: this.year,
                poster: this.poster,
                genre: this.genre,
            };

            console.log(data);

            axios.post(this.linkApi, data, {
                headers: {
                    "Content-type": "multipart/form-data",
                },
            }).then((resp) => {
                this.discFilter();
            });
        },

        openForm() {
            this.formHidden = false;
            window.addEventListener('scroll', this.closeForm);
        },

        closeForm() {
            this.formHidden = true;
            window.removeEventListener('scroll', this.closeOk);
        },

    },
    created() {
        this.discFilter();
    }
}).mount('#app');