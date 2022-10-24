<div class="bg-white rounded-lg py-4">
  <div class="flex items-center justify-between my-2 px-4">
    <div class=""></div>
    <div class="flex space-x-2 items-center">
      <div>
        <input wire:model="search" type="text" class="px-2 py-2 border-2 focus:outline-none rounded border-green-600 placeholder-gray-500 text-sm text-gray-700" placeholder="search for book">
      </div>
      <select wire:model="perPage" class="border-2 px-4 py-2 border-green-600 rounded">
        <option option="5">5</option>
        <option option="10">10</option>
        <option option="20">20</option>
        <option option="24">24</option>
        <option option="50">50</option>
      </select>
    </div>
  </div>
  <div class="px-4">
    <p class="">{{ $collections->links() }}</p>
  </div>
  <div class="flex flex-col md:flex-row flex-wrap">
    @forelse ($collections as $item)
    <div class="w-full  md:w-1/2 lg:w-1/3 xl:w-1/4 2xl:w-1/6 p-4">
      <div class="@if ($item->quantity == 0) cursor-not-allowed bg-red-50  @endif shadow-md w-full rounded overflow-hidden cursor-pointer hover:shadow-xl max-height transition duration-200 transform hover:scale-95 relative">
        {{-- imahe of author --}}
        @if (!$item->isBind == 0)
        <span class="absolute bg-green-600 top-0 right-0 m-2 text-white text-xs px-3 py-2 rounded-2xl font-semibold">Available</span>
        @endif
        <span class="absolute bg-yellow-400 top-0 left-0 m-2 ml-0 mt-0 text-white text-xs  p-2 px-3 rounded-full rounded-l-none font-semibold capitalize ">{{ $item->quantity > 0 ? $item->quantity : 'not available' }}</span>
        <img src="https://via.placeholder.com/100x100.png?text=Uniabuja+Book+Collection" alt="" class="w-full h-auto object-center">
        <div class="p-2 relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 -mt-6 absolute top-0" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
          </svg>
          <p class="pb-3 pt-6 font-medium text-gray-500">{{ Str::of($item->title)->limit(40) }}</p>
          @can('borrow', User::class)
          <div class=" flex justify-between items-center bg-green-200 p-2 w-full rounded-lg">
            <p class=" text-black">
              <span class="font-semibold text-sm px-1">{{ $item->author }}</span>
            </p>
            <button wire:click="borrow({{ $item->id }})" class="text-green-500  bg-white hover:text-green-700  transition duration-500 transform hover:  focus:outline-none p-1 text-center shadow-md rounded-full" @if ($item->quantity == 0) cursor-not-allowed   disabled @endif>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8  text-center mx-auto @if ($item->quantity == 0) hidden  @endif" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
          @endcan
        </div>
      </div>
    </div>
    @empty
    <h2 class="text-2xl">No book in the library</h2>
    @endforelse
  </div>
</div>
