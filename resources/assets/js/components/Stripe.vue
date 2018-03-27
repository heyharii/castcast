<template>

    <div>
        <button class="btn btn-success" @click="subscribe('monthly')">Subscribe to $9.99 Monthly</button>
        <button class="btn btn-info" @click="subscribe('yearly')">Subscribe to $99.9 Yearly</button>
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
                    token(token) {
                        Swal({ text: 'Please wait while we subscribe you to a plan ...', buttons: false});
                        Axios.post('/subscribe', {
                            stripeToken: token.id,
                            name: window.namePlan,
                            plan: window.stripePlan
                        }).then(resp => {
                           Swal({ text: 'Successfully subscribed, Thank you :)', icon: 'success'})
                            .then(() => {
                                window.location = '';  
                            })
                        })
                    }

                })
        },

        data(){
                return {

                    plan : '',
                    amount : 9,
                    handler : null
                
                }
        },

        methods: {
            
            subscribe(plan){

                if(plan == 'monthly'){

                    window.namePlan = 'monthly'
                    window.stripePlan = 'plan_CYEYxtAbre39IO'
                    this.amount = 999
                
                }else {

                    window.namePlan = 'yearly'
                    window.stripePlan = 'plan_CYEZiRkSDX2AwI'
                    this.amount = 9999
                }

                this.handler.open({
                     name: 'Castcast',
                     description: 'Castcast Description',
                     amount: this.amount,
                     email: this.email
                })
            }

        }
    }
</script>