<div class="w-full rounded-xl bg-white p-8">
	<div class="flex items-center justify-between">
		<div class="flex items-center space-x-4">
			<h2 class="my-6 text-2xl font-semibold uppercase text-gray-700 dark:text-gray-200">Library</h2>
		</div>
		<form action="">
			<input type="search" wire:model='search'
				class="w-72 rounded-md border-2 border-green-600 p-2 text-sm placeholder-gray-400"
				placeholder="search book y author, title, genre">
		</form>
	</div>
	@if ($books->count() > 0)
		<div class="grid grid-cols-1 gap-8 md:grid-cols-2 2xl:gap-12">
			@forelse ($books as $book)
				<div class="relative flex flex-col space-x-4 overflow-hidden rounded-lg border hover:shadow md:flex-row">
					<img src="{{ asset('/storage/' . $book->cover_image) }}" alt="{{ $book->authors }}"
						class="w-full object-cover md:h-48 md:w-48">
					<div class="space-y-2 p-2">
						<p class="text-lg font-semibold capitalize">{{ $book->title }}</p>
					</div>
				</div>

			@empty
			@endforelse
		</div>
	@else
		<p class="text-lg">No book in the library at the moment, kindly add books</p>
	@endif
</div>
