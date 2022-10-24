<div class="" x-data="{openCreateModal: @entangle('modal')}">
  <div class="flex justify-between items-center">
    <button class="bg-green-600 text-white py-2 px-4 text-sm rounded hover:opacity-90 uppercase" @click="openCreateModal = true
    ">Add Book</button>
    <form action="">


      {{-- <select wire:model="perPage" id="" class="p-2 border-2 transition duration-500 border-green-600 rounded-md placeholder-gray-400 text-sm">
        <option>5</option>
        <option>10</option>
        <option>20</option>
        <option>50</option>
        <option>100</option>
      </select> --}}
    </form>
  </div>
  {{-- create modal components --}}
  <x-modals.create>
    <form wire:submit.prevent=@if($update) 'update' @else 'save' @endif>
      <div class="p-3 text-gray-500  font-bold">
        <div class="mb-3">
          <input type="text" wire:model="title" class="px-2 py-1 rounded focus-within: focus:outline-none focus:border-green-600 w-full border-2 placeholder-gray-400 font-medium " placeholder="book title here">
          @error('title')
          <span class="text-xs text-red-600 font-normal">{{ $message }}</span>
          @enderror
        </div>
        <div class="mb-3">
          <input type="text" wire:model="author" class="px-2 py-1 rounded focus-within: focus:outline-none focus:border-green-600 w-full border-2 placeholder-gray-400 font-medium " placeholder="book author">
          @error('author')
          <span class="text-xs text-red-600 font-normal">{{ $message }}</span>
          @enderror
        </div>
        <div class="mb-3">
          <select wire:model="isBind" class="px-2 py-2 text-sm rounded focus-within: focus:outline-none focus:border-green-600 w-full border-2 placeholder-gray-400 font-semibold">
            <option value="select">Select whether book is for binding</option>
            <option value=1>True</option>
            <option value=0>False</option>
          </select>
          @error('isBind')
          <span class="text-xs text-red-600 font-normal">{{ $message }}</span>
          @enderror
        </div>
        <div class="mb-3">
          <input type="text" wire:model="quantity" class="px-2 py-1 rounded focus-within: focus:outline-none focus:border-green-600 w-full border-2 placeholder-gray-400 font-medium " placeholder="how many pieces">
          @error('quantity')
          <span class="text-xs text-red-600 font-normal">{{ $message }}</span>
          @enderror
        </div>
        <div class="mb-3">
          <span class="text-yellow-500 text-sm">Optional</span>
          <input type="text" wire:model="cover" class="px-2 py-1 rounded focus-within: focus:outline-none focus:border-green-600 w-full border-2 placeholder-gray-400 font-medium " placeholder="input the book image url">
          @error('cover')
          <span class="text-xs text-red-600 font-normal">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="w-full bg-gray-50 p-3 flex justify-end gap-2">
        <button type="button" x-ref="closeModal" @click="openCreateModal = false" class="rounded border-2 border-gray-300 py-1 text-center px-3 hover:border-gray-700 hover:text-gray-800 text-sm text-gray-500 font-medium">Cancel</button>
        @if($update)
        <button type="submit" class="rounded border-2 border-green-500 bg-green-600 hover:opacity-80 text-white py-1 text-center px-3 text-sm  font-medium">Update</button>
        @else
        <button type="submit" class="rounded border-2 border-green-500 bg-green-600 hover:opacity-80 text-white py-1 text-center px-3 text-sm  font-medium">Save</button>
        @endif
      </div>
    </form>
  </x-modals.create>
  {{-- tables --}}
  <div class="mt-5 border-t-2" x-data="{ tab: 'all'}">
    <div class="flex justify-between items-center">
      <h2 class="text-3xl font-bold my-3">Book Collections</h2>
      <input type="search" wire:model="search" class="p-2 border-2 transition duration-500 border-green-600 rounded-md placeholder-gray-400 text-sm" placeholder="book title or author...">
    </div>
    <ul class="list-none flex  min-w-min rounded-sm overflow-hidden">
      <li class="px-4 py-2 text-sm flex items-center justify-between hover:bg-green-600 bg-white text-white cursor-pointer  w-36 border-r" @click="tab = 'all'" :class="{'border-2 border-b-0 border-gray-200 bg-gray-100 shadow-inner' : tab === 'all'}">
        <span class="font-medium text-black">All</span><span class="py-1 px-2 text-xs bg-pink-500 font-semibold rounded">{{ $all->count() > 0 ? $all->count() : "Non"  }}</span>
      </li>
      <li class="px-4 py-2 text-sm flex items-center justify-between hover:bg-green-600 bg-white text-white cursor-pointer  w-36 border-r" @click="tab = 'available'" :class="{'border-2 border-b-0 border-gray-200 bg-gray-100 shadow-inner' : tab === 'available'}">
        <span class="font-medium text-black">Available</span><span class="py-1 px-2 text-xs bg-green-500 font-semibold rounded">{{ $available->count() }}</span>
      </li>
      <li class="px-4 py-2 text-sm flex items-center justify-between hover:bg-green-600 bg-white text-white cursor-pointer  w-36 border-r" @click="tab = 'bind'" :class="{'border-2 border-b-0 border-gray-200 bg-gray-100 shadow-inner' : tab === 'bind'}">
        <span class="font-medium text-black">Binding</span><span class="py-1 px-2 text-xs bg-blue-500 font-semibold rounded">{{ $binded->count() > 0 ? $binded->count() : "Non"  }}</span>
      </li>
      <li class="px-4 py-2 text-sm flex items-center justify-between hover:bg-green-600 bg-white text-white cursor-pointer  w-36 border-r" @click="tab = 'borrowed'" :class="{'border-2 border-b-0 border-gray-200 bg-gray-100 shadow-inner' : tab === 'borrowed'}">
        <span class="font-medium text-black">Borrowed</span><span class="py-1 px-2 text-xs bg-yellow-500 font-semibold rounded">{{ $borrowed->count()  > 0 ? $borrowed->count() : "Non"}}</span>
      </li>
      <li class="px-4 py-2 text-sm flex items-center justify-between hover:bg-green-600 bg-white text-white cursor-pointer  w-36 border-r" @click="tab = 'lost'" :class="{'border-2 border-b-0 border-gray-200 bg-gray-100 shadow-inner' : tab === 'lost'}">
        <span class="font-medium text-black">Lost</span><span class="py-1 px-2 text-xs bg-yellow-900 font-semibold rounded">{{ $losts->count()  > 0 ? $losts->count() : "Non"}}</span>
      </li>
      <li class="px-4 py-2 text-sm flex items-center justify-between hover:bg-green-600 bg-white text-white cursor-pointer  w-36 border-r" @click="tab = 'overdue'" :class="{'border-2 border-b-0 border-gray-200 bg-gray-100 shadow-inner' : tab === 'overdue'}">
        <span class="font-medium text-black">Overdue</span><span class="py-1 px-2 text-xs bg-indigo-900 font-semibold rounded">{{ $overdues->count()  > 0 ? $overdues->count() : "Non"}}</span>
      </li>
    </ul>
    {{-- contents --}}
    <div class="bg-white mt-0 ">
      {{-- <div class="flex item-center justify-between mt-2 mb-4">
        <a href=""></a>
      </div> --}}
      <div x-show="tab === 'all'" x-transition.duration.1000ms.origin.top class="">
        <table class="table-auto w-full rounded overflow-hidden shadow ">
          <thead>
            <tr class=" font-normal bg-gray-50 border px- text-white text-left">
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">No</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Author</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Title</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Cover Image</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Quantity</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600 text-center">Available</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Updated At</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($all as $book)
            <tr class="border border-t-0 text-sm text-gray-700 font-medium">
              <td class="p-2">{{ $loop->iteration }}</td>
              <td class="p-2 flex space-x-1 items-center">
                <img src="{{ $book->cover }}" alt="Gods people" class="rounded-full w-10 h-10"><span>{{ $book->author }}
                </span>
              </td>
              <td class="p-2">{{ $book->title }}</td>
              <td class="p-2">
                <img src="{{ $book->cover }}" alt="Gods people" class="rounded-sm w-10 h-10">
              </td>
              <td class="p-2">{{ $book->quantity }}</td>
              <td class="p-2 text-center text-xs font-medium text-white uppercase">
                <span x-data="{isBind: {{ $book->isBind }} }" :class="isBind ? 'bg-red-600' : 'bg-green-600'" class="p-2 rounded text-xs font-semibold">{{ $book->isBind == true ? 'No' : 'Yes' }}</span>
              </td>
              <td class="p-2">{{ $book->updated_at->diffForHumans() }}</td>
              <td class="p-2 flex items-center justify-start">
                <button wire:click="edit({{ $book->id }})" class=" rounded-sm text-white bg-blue-600 hover:opacity-80 transition duration-500 p-1 mx-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                  </svg>
                </button>
                <button wire:click="confirmDelete({{ $book->id }})" class=" rounded-sm text-white bg-red-600 hover:opacity-80 transition duration-500 p-1 mx-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </td>
            </tr>
            @endforeach
            @if ($all->count() > 0)
          <tfoot>
            <tr>
              <td colspan="6">
                <p class="my-2">{{ $books->links() }}</p>
              </td>
            </tr>
          </tfoot>
          @endif
          </tbody>
        </table>
      </div>
      <div x-show="tab === 'available'" x-transition.duration.500ms class="">
        <table class="table-auto w-full rounded overflow-hidden shadow ">
          <thead>
            <tr class=" font-normal bg-gray-50 border px- text-white text-left">
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">No</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Author</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Title</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Cover Image</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Quantity</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Updated At</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($books as $book)
            <tr class="border border-t-0 text-sm text-gray-700 font-medium">
              <td class="p-2">{{ $loop->iteration }}</td>
              <td class="p-2">{{ $book->author }}</td>
              <td class="p-2">{{ $book->title }}</td>
              <td class="p-2">
                <img src="{{ $book->cover }}" alt="Gods people" class="rounded-sm w-10 h-10 ">
              </td>
              <td class="p-2">{{ $book->quantity }}</td>
              <td class="p-2">{{ $book->updated_at->diffForHumans() }}</td>
              <td class="p-2 flex items-center justify-start">
                <button wire:click="bind({{ $book->id }})" class=" rounded-sm text-white text-xs flex space-x-1 bg-yellow-500 hover:opacity-80 transition duration-500 p-1 px-2 mx-1" x-data="{bind: 'Send for Binding'}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" x-tooltip.placement.top="bind">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd" />
                  </svg>
                  <span>Send for binding</span>
                </button>
              </td>
            </tr>
            @endforeach
            @if ($books->count() > 0)
          <tfoot>
            <tr>
              <td colspan="6">
                <p class="my-2">{{ $books->links() }}</p>
              </td>
            </tr>
          </tfoot>
          @endif
          </tbody>
        </table>
      </div>
      <div x-show="tab === 'bind'" x-transition.duration.500ms.origin.top class="">
        <table class="table-auto w-full rounded overflow-hidden shadow ">
          <thead>
            <tr class=" font-normal bg-gray-50 border px- text-white text-left">
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">No</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Author</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Title</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Cover Image</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Quantity</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Sent Date</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($binds as $book)
            <tr class="border border-t-0 text-sm text-gray-700 font-medium">
              <td class="p-2">{{ $loop->iteration }}</td>
              <td class="p-2">{{ $book->author }}</td>
              <td class="p-2">{{ $book->title }}</td>
              <td class="p-2">
                <img src="{{ $book->cover }}" alt="Gods people" class="rounded-sm w-10 h-10 ">
              </td>
              <td class="p-2">{{ $book->quantity }}</td>
              <td class="p-2">{{ date_format($book->updated_at,'d M Y') }}</td>
              <td class="p-2 flex items-center justify-start">
                <button wire:click="return({{ $book->id }})" class="px-3 rounded-sm text-white text-xs bg-green-500 hover:opacity-80 transition duration-500 py-1 mx-1">
                  Binded Finish
                </button>
              </td>
            </tr>
            @endforeach
            @if ($binds->count() > 0)
          <tfoot>
            <tr>
              <td colspan="6">
                <p class="my-2">{{ $binds->links() }}</p>
              </td>
            </tr>
          </tfoot>
          @endif
          </tbody>
        </table>
      </div>
      <div x-show="tab === 'borrowed'" x-transition.duration.500ms.origin.top class="">
        <table class="table-auto w-full rounded overflow-hidden shadow ">
          <thead>
            <tr class=" font-normal bg-gray-50 border px- text-white text-left">
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">No</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Borrower ID</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Book Borrowed</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Date Borrowed</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Expected Return Date</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Returned or Pay</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Status</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($borrowers as $book)
            <tr class="border border-t-0 text-sm text-gray-700 font-medium">
              <td class="p-2">{{ $loop->iteration }}</td>
              <td class="p-2">{{ $book->user->library_id }}</td>
              <td class="p-2">{{ $book->book->title }}</td>
              <td class="p-2">{{ formatDate($book->date_borrowed) }}</td>
              <td class="p-2">{{ returnDate($book->date_borrowed) }}</td>
              <td class="p-2 capitalize">
                @if ($book->date_returned == null )
                @if ($book->status == 'lost')
                <span>Never Return</span>
                @else
                <span>Not Yet</span>
                @endif
                @else
                <span class="">{{ returnDateTime($book->date_returned) }}</span>
                @endif
              </td>
              <td class="p-2 capitalize">{{ $book->status }}</td>
              <td class="p-2 flex items-center justify-start">
                @if ($book->status == 'reading')
                <button wire:click="returnBook({{ $book->id }})" class="px-2 rounded-sm text-dark text-xs bg-green-500 hover:opacity-80 transition duration-500 py-1 mx-1">
                  Return Book
                </button>
                <button wire:click="lost({{ $book->id }})" class="px-2 rounded-sm text-white text-xs bg-pink-500 hover:opacity-80 transition duration-500 py-1 mx-1">
                  Lost
                </button>
                @else
                <span class="">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-not-allowed text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  </svg>
                </span>
                @endif
              </td>
            </tr>
            @endforeach
            @if ($borrowers->count() > 0)
          <tfoot>
            <tr>
              <td colspan="6">
                <p class="my-2">{{ $borrowers->links() }}</p>
              </td>
            </tr>
          </tfoot>
          @endif
          </tbody>
        </table>
      </div>
      <div x-show="tab === 'lost'" x-transition.duration.500ms.origin.top class="">
        <table class="table-auto w-full rounded overflow-hidden shadow ">
          <thead>
            <tr class=" font-normal bg-gray-50 border px- text-white text-left">
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">No</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Borrower Details</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Book Borrowed</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Date Borrowed</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Date Lost</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Date Payed</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($losts as $book)
            <tr class="border border-t-0 text-sm text-gray-700 font-medium">
              <td class="p-2">{{ $loop->iteration }}</td>
              <td class="p-2 flex flex-col font-semibold text-gray-500">
                <span class="">Name: {{ $book->user->name }}</span>
                <span class="">Phone: {{ $book->user->phone }}</span>
                <span class="">Email: {{ $book->user->email }}</span>
              </td>
              <td class="p-2">{{ $book->book->title }}</td>
              <td class="p-2">{{ formatDate($book->date_borrowed) }}</td>
              <td class="p-2">{{ formatDate($book->date_lost) }}</td>
              <td class="p-2 capitalize">{{ $book->date_returned == null ? 'Not yet' : returnDateTime($book->date_returned) }}</td>
              <td class="p-2">
                @if ($book->date_returned == null && $book->date_lost)
                <a href="https://www.remita.net" class="px-2 items-center  text-white rounded-sm text-dark text-xs bg-green-600 hover:opacity-80 transition duration-500 py-1 mx-1">
                  Pay
                </a>
                @elseif($book->status == 'payed')
                <button class="px-2 rounded-sm text-dark text-xs text-white bg-green-600 hover:opacity-80 transition duration-500 py-1 mx-1">
                  <span class="">Paid</span>
                  <span class="">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                    </svg>
                  </span>
                </button>
                @else
                <span class="">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                  </svg>
                </span>
                @endif
              </td>
            </tr>
            @endforeach
            @if ($losts->count() > 0)
          <tfoot>
            <tr>
              <td colspan="6">
                <p class="my-2">{{ $losts->links() }}</p>
              </td>
            </tr>
          </tfoot>
          @endif
          </tbody>
        </table>
      </div>

      {{-- overdues books here --}}
      <div x-show="tab === 'overdue'" x-transition.duration.1000ms.origin.top class="">
        <table class="table-auto w-full rounded overflow-hidden shadow ">
          <thead>
            <tr class=" font-normal bg-gray-50 border px- text-white text-left">
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">No</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Borrower Name</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Overdue Book</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Overdue Days</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Date Returned</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Status</th>
              <th class="font-semibold text-sm py-2 pl-2 text-gray-600">Payment Message</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($overdues as $book)
            <tr class="border border-t-0 text-sm text-gray-700 font-medium">
              <td class="p-2">{{ $loop->iteration }}</td>
              <td class="p-2">{{ $book->user->name }}</td>
              <td class="p-2">{{ $book->book->title }}</td>
              <td class="p-2">{{ formatDate($book->date_borrowed) }}</td>
              <td class="p-2">{{ returnDate($book->date_borrowed) }}</td>
              <td class="p-2 capitalize">{{ $book->date_returned == null ? 'Not yet' : returnDateTime($book->date_returned) }}</td>
              <td class="p-2 capitalize">{{ $book->date_returned == null ? 'Not yet' : returnDateTime($book->date_returned) }}</td>
            </tr>
            @endforeach
            @if ($overdues->count() > 0)
          <tfoot>
            <tr>
              <td colspan="6">
                <p class="my-2">{{ $overdues->links() }}</p>
              </td>
            </tr>
          </tfoot>
          @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
