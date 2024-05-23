const {createApp} = Vue;

const app = createApp({
    

    data() { //dati
        return {
            discList: [],
        }
    },
    methods: {

    },
    created() {
        axios.get('http://localhost/boolean-php/php-dischi-json/server.php').then((resp) => {            
            this.discList = resp.data.response;
        })
    }
}).mount('#app');