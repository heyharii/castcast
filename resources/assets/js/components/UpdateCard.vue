<template>

    <div>
       
        <button class="btn btn-info" @click="update">Update card details</button>
    </div>

</template>

<script>
    import Swal from 'sweetalert'
    import Axios from 'axios'
    export default {

        props: ['email'],

        mounted() {
                
                this.handler = StripeCheckout.configure({
                    
                    key: 'pk_test_kiHNC5vzFBpS5sZjpLSIE3Sz',
                    image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                    locale: 'auto',
                    allowRememberMe: false,
                    token(token) {
                        Swal({ text: 'Please wait while we update your card details ...', buttons: false});
                        Axios.post('/card/update', {
                            stripeToken: token.id
                        }).then(resp => {
                           Swal({ text: 'Successfully updated card details', icon: 'success'})
                            .then(() => {
                                window.location = '';  
                            })
                        })
                    }

                })
        },

        data(){
                return {

                    handler : null
                
                }
        },

        methods: {
            
            update(plan){

                this.handler.open({
                     name: 'Castcast',
                     description: 'Castcast Description',
                     email: this.email,
                     panelLabel: 'Update card details'
                })
            }

        }
    }
</script>