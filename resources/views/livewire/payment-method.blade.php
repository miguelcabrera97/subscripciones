<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <section class="bg-white rounded shadow-lg mb-12">
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

    <div class="mb-12 justify-center" wire:target='addPaymentMethod' wire:loading.flex>
        <div role="status">
            <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="currentColor" />
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentFill" />
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    @if (count($paymentMethods))
    <section class="bg-white rounded shadow-lg">
        <header class="px-8 py-6">
            <h1 class="text-center text-lg">Metodos de Pago</h1>
        </header>
        <div class="py-6 px-8">
            <ul class="divide-y ">
                @foreach ($paymentMethods as $paymentMethod)
                <li class="py-2 flex justify-between" wire:key='{{$paymentMethod->id}}'>
                    <div class="">
                        <span class="font-semibold">{{$paymentMethod->billing_details->name}}</span>
                        xxxx-{{$paymentMethod->card->last4}}
                        @if ($this->DefaultPaymentMethod->id == $paymentMethod->id)
                        <span class="ml-5 bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Predeterminado</span>
                        @endif

                        <p>Expira: {{$paymentMethod->card->exp_month}}/{{$paymentMethod->card->exp_year}}</p>

                    </div>
                    @if ($this->DefaultPaymentMethod->id != $paymentMethod->id)
                    <div class="flex space-x-4">
                        <button class="disabled:opacity-25" wire:click="defaultPaymentMethod('{{$paymentMethod->id}}')"
                            wire:target="defaultPaymentMethod('{{$paymentMethod->id}}')" wire:loading.attr='disabled'>
                            <i class="fa-regular fa-star"></i>
                        </button>
                        <button class="disabled:opacity-25" wire:click="deletePaymentMethods('{{$paymentMethod->id}}')"
                            wire:target="deletePaymentMethods('{{$paymentMethod->id}}')" wire:loading.attr='disabled'>
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </section>
    @endif


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
