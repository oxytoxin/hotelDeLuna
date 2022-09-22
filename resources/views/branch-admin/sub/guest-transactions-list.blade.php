 <div class="flex flex-col ">
     <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
         <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
             <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                 <div class="flex justify-between px-4 py-3 bg-white border-b border-gray-200 sm:px-6">
                     <div class="flex items-center space-x-4">
                         <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor"
                             class="w-6 h-6">
                             <path stroke-linecap="round"
                                 stroke-linejoin="round"
                                 d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                         </svg>
                         <h1 class="text-xl"> Transactions</h1>
                     </div>
                     <div class="flex space-x-3">
                         @if ($loadTransactions == true)
                             <x-button wire:click="$set('extendModal',true)"
                                 label="Extend" />
                             <x-button wire:click="showChangeRoomModal"
                                 label="Change Room" />
                         @endif
                     </div>
                 </div>
                 <table class="min-w-full divide-y divide-gray-300">
                     <thead class="divide-y divide-gray-200 bg-gray-50">
                         <tr>
                             <th scope="col"
                                 class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                 Type
                             </th>
                             <th scope="col"
                                 class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                 Amount To Pay
                             </th>
                             <th scope="col"
                                 class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                 Paid At
                             </th>
                         </tr>
                     </thead>
                     <tbody class="bg-white divide-y divide-gray-200">
                         @foreach ($transactions as $transaction)
                             <tr>
                                 <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                     {{ $transaction->transaction_type->name }}
                                     @if ($transaction->transaction_type_id == 1)
                                         | Room # {{ $transaction->check_in_detail->room->number }}
                                     @endif
                                 </td>
                                 <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                     &#8369; {{ $transaction->payable_amount }}
                                 </td>
                                 <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                     @if ($transaction->paid_at)
                                         {{ $transaction->paid_at }}
                                     @else
                                         <button type="button"
                                             wire:click="payTransaction({{ $transaction->id }})"
                                             class="flex items-center space-x-2 font-medium text-green-600 hover:text-green-500">
                                             <svg xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="1.5"
                                                 stroke="currentColor"
                                                 class="w-6 h-6">
                                                 <path stroke-linecap="round"
                                                     stroke-linejoin="round"
                                                     d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                             </svg>
                                             <span> Pay</span>
                                         </button>
                                     @endif
                                 </td>
                             </tr>
                         @endforeach
                         <tr>
                             <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                 --
                             </td>
                             <td class="py-4 pl-4 pr-3 text-sm font-bold text-gray-900 whitespace-nowrap sm:pl-2">
                                 Total : @if ($loadTransactions == true)
                                     &#8369; {{ $transactions->sum('payable_amount') }}
                                 @else
                                     --
                                 @endif
                             </td>
                             <td class="py-4 pl-4 pr-3 text-sm font-bold text-gray-900 whitespace-nowrap sm:pl-2">
                                 Balance : @if ($loadTransactions == true)
                                     &#8369; {{ $transactions->where('paid_at', null)->sum('payable_amount') }}
                                 @else
                                     --
                                 @endif
                             </td>

                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
 </div>
