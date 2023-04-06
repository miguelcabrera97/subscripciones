<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <section class="bg-white rounded shadow-lg">
        <div class="py-6 px-8">
            <h1 class="text-gray-700 mb-5 font-semibold text-lg">Agregar metodo de pago</h1>
            <div class="flex" wire:ignore>
                <p class="mr-5 mt-2">Informacion de la Tarjeta:</p>
                <div class="flex-1">
                    <input class="form-control mb-4" id="card-holder-name" placeholder="Nombre del Titular">
                    <div id="card-element" class="form-control mb-4"></div>
                    <span id="card-error-message" class="text-red-600 text-sm"></span>
                </div>

            </div>
            <!-- Stripe Elements Placeholder -->
        </div>
        <footer class="px-8 py-6">
            <div class="flex justify-end">
                <x-button id="card-button" data-secret="{{ $intent->client_secret }}">
                    Update Payment Method
                </x-button>
            </div>
        </footer>
    </section>

    @push('js')
        <script>
            const stripe = Stripe("{{ env('STRIPE_KEY') }}");
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');
        </script>

        <script>
            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');


            cardButton.addEventListener('click', async (e) => {
                //desactivar boton
                cardButton.disabled=true;

                const clientSecret = cardButton.dataset.secret;

                const {
                    setupIntent,
                    error
                } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: cardHolderName.value
                            }
                        }
                    }
                );

                cardButton.disabled=false;

                if (error) {
                    let span = document.getElementById('card-error-message');
                    span.textContent = error.message;

                } else {
                    //Limpiar
                    cardHolderName.value = '';
                    cardElement.clear();

                    @this.addPaymentMethod(setupIntent.payment_method);
                    // The card has been verified successfully...
                }
            });
        </script>
    @endpush

    <script src="https://js.stripe.com/v3/"></script>


</div>
