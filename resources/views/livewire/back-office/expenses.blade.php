<div>
  <div class="border rounded-lg flex justify-between items-center p-2 py-3 shadow-lg">
    <div class="flex justify-center space-x-1 items-center">

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

  {{-- <div class="mt-5">
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

  </div> --}}
  <div class="">
    <div class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full">
              <thead class="bg-white">
                <tr>
                  <th width="110" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">
                  </th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">EXPENSE NAME</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">DESCRIPTION</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">AMOUNT</th>

                </tr>
              </thead>
              <tbody class="bg-white">
                @foreach ($categories as $category)
                  <tr class="border-t border-gray-200">
                    <th colspan="6" scope="colgroup"
                      class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold uppercase text-gray-900 sm:px-6">
                      {{ $category->name }}</th>
                  </tr>
                  @foreach ($category->expenses as $item)
                    <tr class="border-t border-gray-300">
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700"></td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $item->name }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $item->description }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                        &#8369;{{ number_format($item->amount, 2) }}
                      </td>

                    </tr>
                  @endforeach
                @endforeach



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
          @forelse ($categories as $key => $category)
            <li wire:key="{{ $key }}">
              <div class="px-4 hover:bg-gray-50 py-2 sm:px-6 s">
                <div class="flex items-center justify-between">
                  <p class="truncate text-sm font-semibold uppercase text-gray-600 ">{{ $category->name }}</p>
                  <div class="ml-2 flex flex-shrink-0">
                    <x-button wire:click="editCategory({{ $category->id }})" sm icon="pencil" label="Edit"
                      positive />
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
  <div wire:key="update_expense" class="z-0">
    <x-modal.card max-width="sm" title="Update Category " blur wire:model.defer="update_expense">
      <x-input label="Expense Category" placeholder="Enter name" wire:model.defer="category_name" />
      <x-slot:footer>
        <div class="flex w-full justify-end items-center space-x-2">
          <x-button positive wire:click="updateCategory">Save</x-button>
          <x-button wire:click="$set('update_expense', false)" default>Cancel</x-button>
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
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Amount</label>
          <div class="mt-1">
            <input type="number" wire:model.defer="expense_amount"
              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 sm:text-sm">
          </div>
        </div>
      </div>

      <x-slot:footer>
        <div class="flex w-full justify-end items-center space-x-2">
          <x-button positive wire:click="saveExpense">Save</x-button>
          <x-button wire:click="$set('add_expense_modal', false)" default>Cancel</x-button>
        </div>
      </x-slot:footer>
    </x-modal.card>
  </div>
  <div wire:key="manage_employee" class="z-0">
    <x-modal.card max-width="5xl" title="Manage Employee " blur wire:model.defer="manage_employee">
      <h1 class="font-bold uppercase">{{ $employee_name }}</h1>

      <div class="mt-5">
        <div class="sm:hidden">
          <label for="tabs" class="sr-only">Select a tab</label>
          <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
          <select id="tabs" name="tabs"
            class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option selected>My Account</option>

            <option>Company</option>

            <option>Team Members</option>

            <option>Billing</option>
          </select>
        </div>
        <div class="hidden sm:block">
          <nav class="isolate flex divide-x divide-gray-200  shadow" aria-label="Tabs">
            <!-- Current: "text-gray-900", Default: "text-gray-500 hover:text-gray-700" -->


            @foreach ($categories as $item)
              <a href="#"
                class="text-gray-500 hover:text-gray-700 group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10">
                <span>{{ $item->name }}</span>
                <span aria-hidden="true" class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
              </a>
            @endforeach


          </nav>
        </div>
      </div>
    </x-modal.card>




  </div>
</div>
