<x-app-layout>
    <x-container class="py-12">
        <div class="grid grid-cols-3 gap-6">
            @foreach ($products as $product)
                <div class="bg-white rounded shadow-lg">
                    <div class="h-56 bg-cover bg-center " style="background-image: url({{$product->image}})">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium p-1 m-4 rounded dark:bg-blue-900 dark:text-blue-300">
                            {{$product->price}} USD
                        </span>
                    </div>
                    {{-- <img class="h-56 w-full object-cover" src="{{$product->image}}" alt=""> --}}
                    <div class="px-6 py-4">
                        <h1 class="text-gray-900 font-semibold text-lg uppercase">
                            {{$product->title}}
                        </h1>

                        <p>{{Str::limit($product->description, 50)}}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{$products->links()}}
        </div>
    </x-container>
</x-app-layout>
