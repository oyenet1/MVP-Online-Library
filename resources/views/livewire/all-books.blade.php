<div class="mt-">
    <div class="flex justify-between items-center">
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 uppercase">All Books</h2>
      <form action="">
        <input type="search" wire:model.search class="p-2 border-2 border-green-600 rounded-md placeholder-gray-400 text-sm" placeholder="search book">
      </form>
    </div>
    <table class="table-auto w-full border-collapse border rounded overflow-hidden shadow border-white">
      <thead>
        <tr class=" font-normal bg-green-500 border px- text-white text-left">
          <th class="font-normal py-2 pl-2 text-black">No</th>
          <th class="font-normal py-2 pl-2 text-black">Author</th>
          <th class="font-normal py-2 pl-2 text-black">Title</th>
          <th class="font-normal py-2 pl-2 text-black">Cover Image</th>
          <th class="font-normal py-2 pl-2 text-black">Quantity</th>
          <th class="font-normal py-2 pl-2 text-black">Updated At</th>
          <th class="font-normal py-2 pl-2 text-black">Action</th>
        </tr>
      </thead>

      <tbody>
        @forelse ($books as $book)
        <tr class="border">
            <td class="p-2">{{ $loop->iteration }}</td>
            <td class="p-2">{{ $book->author }}</td>
            <td class="p-2">{{ $book->title }}</td>
            <td class="p-2">
              <img src="{{ $book->cover }}" alt="Gods people" class="rounded-sm w-10 h-10 ">
            </td>
            <td class="p-2">{{ $book->quantity }}</td>
            <td class="p-2">{{ $book->updated_at->diffForHumans() }}</td>
            <td class="p-2 flex items-center justify-start">
              <a href="" class=" rounded-sm text-white bg-blue-600 hover:opacity-80 transition duration-500 p-1 mx-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
              </a>
              <a href="" class=" rounded-sm text-white bg-red-600 hover:opacity-80 transition duration-500 p-1 mx-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </a>
            </td>
          </tr>
        @empty
            <h2>No books yet in the shelf</h2>
        @endforelse
        @if ($books->count() > 0)
            <p class="my-2">{{ $books->links() }}</p>
        @endif
      </tbody>
    </table>
  </div>