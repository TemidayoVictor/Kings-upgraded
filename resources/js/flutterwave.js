window.openFlutterwaveCheckout = function (options) {
    FlutterwaveCheckout({
        public_key: options.public_key,
        tx_ref: options.tx_ref,
        amount: options.amount,
        currency: options.currency ?? "NGN",
        payment_options: "card,banktransfer,ussd",

        customer: {
            email: options.email,
            phone_number: options.phone,
            name: options.name,
        },

        customizations: {
            title: options.title,
            description: options.description,
            logo: options.logo,
        },

        redirect_url: options.redirect_url,

        meta: options.meta ?? {},
    });
};
