// ---------- COMPONENT EVENTOS-CONTAINER ----------
var eventosContainer = Vue.component('eventos-container', {
    props: ['eventos'],
    data: function () {
        return {
            loading: false,
            evento: null
        }
    },
    template: '#eventos-container'
});

// ---------- COMPONENT EVENTO-DETALHES ----------
var eventoDetalhes = Vue.component('evento-detalhes', {
    data: function () {
        return {
            loading: true,
            evento: null
        }
    },
    computed: {
        imagem: function(){
            return this.evento.imagem == null ? '/img/eventos/default.png' : '/img/eventos/'+this.evento.imagem;
        },
        data_formatada: function(){
            return formatarData(this.evento.data_hora.date)
        },
        hora_formatada: function(){
            return formatarHora(this.evento.data_hora.date)
        }
    },
    created: function(){
        var instancia = this;
        axios.get('/api/v1/evento/'+instancia.$route.params.id)
        .then(function (response) {
            instancia.evento = response.data;
            instancia.loading = false;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    template: '#evento-detalhes'
});

// ---------- COMPONENT EVENTO ----------
var evento = Vue.component('evento',{
    props: ['evento'],
    computed: {
        imagem: function(){
            return this.evento.imagem == null ? '/img/eventos/default.png' : '/img/eventos/'+this.evento.imagem;
        },
        data_formatada: function(){
            return formatarData(this.evento.data_hora.date)
        },
        hora_formatada: function(){
            return formatarHora(this.evento.data_hora.date)
        }
    },
    template: '#evento'
});

// ---------- COMPONENT INSCRICOES-CONTAINER ----------
var inscricoesContainer = Vue.component('inscricoes-container', {
    data: function () {
        return {
            inscricoes: null,
            loading: true,
        }
    },
    methods: {
        buscarInscricoes: function(){
            this.loading = true;
            var instancia = this;
            axios.get('/api/v1/inscricao/'+instancia.$route.params.id+'/'+instancia.$route.params.token)
            .then(function (response) {
                instancia.inscricoes = response.data;
                instancia.loading = false;
            })
            .catch(function (error) {
                console.log(error);
                instancia.loading = false;
            });
        },
        pagar: function(inscricao){ //SIMULACAO DE PAGAMENTO
            this.loading = true;
            var instancia = this;
            inscricao.pago = 1;
            inscricao.fb_ID = app.user.userID;
            inscricao.fb_Token = app.user.userToken;
            axios.put('/api/v1/inscricao/'+inscricao.id, inscricao)
            .then(function (response) {
                alert('Pagamento realizado com sucesso!');
                instancia.buscarInscricoes();
            })
            .catch(function (error) {
                console.log(error);
                instancia.loading = false;
            });
        },
        cancelar: function(id_inscricao){
            this.loading = true;
            var instancia = this;
            axios.delete('/api/v1/inscricao/'+id_inscricao+'/'+app.user.userID+'/'+app.user.userToken)
            .then(function (response) {
                alert('Inscrição cancelada!');
                instancia.buscarInscricoes();
            })
            .catch(function (error) {
                console.log(error);
                instancia.loading = false;
            });
        }
    },
    created: function(){
        this.buscarInscricoes();
    },
    template: '#inscricoes-container'
});

// ---------- ROTAS / ROUTER  ----------
const routes = [
    {path: '/', name:'eventos', component: eventosContainer},
    {path: '/eventos', name:'eventos', component: eventosContainer},
    {path: '/evento/:id', name:'evento', component: eventoDetalhes},
    {path: '/inscricoes/:id/:token', name:'inscricoes', component: inscricoesContainer},
];
const router = new VueRouter({routes, mode:'history'});

// ---------- APP ----------
var app = new Vue({
    el: '#app',
    data: {
        eventos:null,
        logado: false,
        loading: true,
        user: {
            userName: null,
            userToken: null,
            userID: null,
            email: null
        },
        tipo_ingresso: null,
        nome_inscrito: null
    },
    created: function(){
        if(localStorage.getItem('userName') && localStorage.getItem('userName') !== ''){
            this.user.userName = localStorage.getItem('userName');
            this.user.userToken = localStorage.getItem('userToken');
            this.user.userID = localStorage.getItem('userID');
            this.user.email = localStorage.getItem('email');
            var instancia = this;
            //Verifica se token ja expirou
            axios.get('https://graph.facebook.com/'+this.user.userID+'?fields=id,name&access_token=' + this.user.userToken)
            .then(function (response) {
                console.log('Usuário logado!')
                instancia.logado = true;
            })
            .catch(function (error) {
                var res = error.response.data.error;
                console.log(res);
                if(res.error_subcode && res.error_subcode == 463){ //Token Expirado
                    console.log('FB Token expirado.')
                    logOut();
                }
            });
        }
        var instancia = this;
        axios.get('/api/v1/evento')
        .then(function (response) {
            instancia.eventos = response.data;
            instancia.loading = false;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    methods: {
        inscrever: function(){
            if ($("input[name='cat_ingresso']:checked").val()) {
                if($.trim($('#nome').val()) !== ''){
                    this.loading = true;
                    var instancia = this;
                    axios.post('/api/v1/inscricao', {
                        fb_ID: instancia.user.userID,
                        fb_Token: instancia.user.userToken,
                        nome: instancia.nome_inscrito,
                        email: instancia.user.email,
                        id_ingresso: instancia.tipo_ingresso
                    })
                    .then(function (response) {
                        instancia.loading = false;
                        instancia.tipo_ingresso = null;
                        instancia.nome_inscrito = null;
                        alert('Inscrição realizada com sucesso!');
                        router.push({ name: 'inscricoes', params: { id: instancia.user.userID, token: instancia.user.userToken } });
                    })
                    .catch(function (error) {
                        instancia.loading = false;
                        console.log(error.response.data);
                    });
                }else{
                    alert('Informe o nome do inscrito!');
                }
            }
            else {
                alert('Selecione o tipo de ingresso!');
            }
        },
        formatarValor: function(valor){
            return valor.replace(".", ",");
        }
    },
    router
});
