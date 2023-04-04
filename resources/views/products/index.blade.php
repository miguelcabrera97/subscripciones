<x-app-layout>
    <x-container class="py-12">
        <div class="grid grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white rounded shadow-lg">
                    <img class="h-56 w-full object-cover" src="{{$product->image}}" alt="">
                    <div class="px-6 py-4">
                        <h1 class="text-gray-900 font-semibold text-xl uppercase">
                            {{$product->title}}
                        </h1>
                    </div>
                </div>
            @endforeach
        </div>
    </x-container>
</x-app-layout>
