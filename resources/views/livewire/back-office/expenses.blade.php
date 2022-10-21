<div>
  <div class="border rounded-lg flex justify-between items-center p-2 py-3 shadow-lg">
    <div>
      sdsd
    </div>
    <div class="flex space-x-1 items-center justify-center">
      <x-button wire:click="$set('create_modal', true)" slate label="MANAGE CATEGORY" class="font-semibold" />
      <x-button positive wire:click="$set('add_expense_modal', true)">
        <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          viewBox="0 0 24 24" stroke="currentColor">
          <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
      </x-button>
    </div>
  </div>

  <div class="mt-5">
    <div class="">
      <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-300">
              <thead>
                <tr>
                  <th scope="col"
                    class="py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-700 uppercase sm:pl-6 md:pl-0">
                    Name</th>
                  <th scope="col" class="py-2 px-3 text-left text-sm font-semibold text-gray-700 uppercase">Expense
                  </th>
                  <th scope="col" class="py-2 px-3 text-left text-sm font-semibold text-gray-700 uppercase">
                    Description</th>
                  <th scope="col" class="py-2 px-3 text-left text-sm font-semibold text-gray-700 uppercase">Amount
                  </th>
                  <th scope="col" class="relative py-2 pl-3 pr-4 sm:pr-6 md:pr-0">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @forelse ($expenses as $expense)
                  <tr>
                    <td class="whitespace-nowrap py-3 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 md:pl-0">
                      {{ $expense->name }}</td>
                    <td class="whitespace-nowrap py-3 px-3 text-sm text-gray-500">{{ $expense->expense_category->name }}
                    </td>
                    <td class="whitespace-nowrap py-3 px-3 text-sm text-gray-500">{{ $expense->description }}</td>
                    <td class="whitespace-nowrap py-3 px-3 text-sm text-gray-500">
                      &#8369;{{ number_format($expense->amount, 2) }}</td>
                    <td
                      class="relative whitespace-nowrap py-3 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 md:pr-0">
                      <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">,
                          Lindsay
                          Walton</span></a>
                    </td>
                  </tr>
                @empty
                @endforelse

                <!-- More people... -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>


  <div wire:key="create_modal" class="z-0">
    <x-modal.card title="Add New Category " blur wire:model.defer="create_modal">
      <x-input label="Expense Category" placeholder="Enter name" wire:model.defer="category_name" />

      <div class="overflow-hidden bg-white mt-5 shadow sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200">
          @forelse ($categories as $category)
            <li>
              <div class="px-4 hover:bg-gray-50 py-2 sm:px-6">
                <div class="flex items-center justify-between">
                  <p class="truncate text-sm font-semibold uppercase text-gray-600 ">{{ $category->name }}</p>
                  <div class="ml-2 flex flex-shrink-0">
                    <x-button sm icon="pencil" label="Edit" positive />
                  </div>
                </div>

              </div>
            </li>
          @empty
            <li>
              <div class="px-4 hover:bg-gray-50 py-2 sm:px-6">
                <div class="flex items-center justify-between">
                  <p class="truncate text-sm font-medium text-indigo-600">No Category</p>
                </div>
              </div>
            </li>
          @endforelse
        </ul>
      </div>

      <x-slot:footer>
        <div class="flex w-full justify-end items-center space-x-2">
          <x-button positive wire:click="saveCategory">Save</x-button>
          <x-button wire:click="$set('create_modal', false)" default>Cancel</x-button>
        </div>
      </x-slot:footer>
    </x-modal.card>
  </div>
  <div wire:key="add_expense_modal" class="z-0">
    <x-modal.card title="Add New Category " blur wire:model.defer="add_expense_modal">
      <div class="grid grid-cols-2 gap-4">
        <x-input label="Employee Name" placeholder="Enter name" wire:model.defer="expense_name" />
        <x-native-select label="Select Category" wire:model="expense_category_id">
          <option selected>Select Category</option>
          @foreach ($categories as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
          @endforeach
        </x-native-select>
        <x-textarea label="Description" placeholder="write your reasons" wire:model.defer="expense_description" />
        <x-input label="Amount" placeholder="" wire:model.defer="expense_amount" />
      </div>

      <x-slot:footer>
        <div class="flex w-full justify-end items-center space-x-2">
          <x-button positive wire:click="saveExpense">Save</x-button>
          <x-button wire:click="$set('add_expense_modal', false)" default>Cancel</x-button>
        </div>
      </x-slot:footer>
    </x-modal.card>
  </div>
</div>
