<div>
    <div class="header flex items-center justify-between">
        <div class="welcome">
            <h1 class="text-2xl font-semibold text-gray-600">Dashboard</h1>
            <h1 class="text-gray-500 text-sm">A visual display of all of your data.</h1>
        </div>
    </div>
    @php
        $orders = App\Models\Transaction::where('transaction_type_id',3)->count();
        $categories = App\Models\FoodCategory::count();
        $foods = App\Models\Meal::count();
    @endphp
    <div class="mt-10 bg-gray-50 p-2 flex rounded-3xl shadow-lg">
        <div class="grid grid-cols-4  py-10 w-full gap-4">
            <div class="side-text text-center grid place-content-center">
                <span>
                    General Statitics of users engagement process.
                </span>
            </div>
            <div class="bg-white relative border rounded-2xl p-4">
                <div class="absolute -top-7 h-10 w-10 rounded-xl grid place-content-center bg-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-white" width="24"
                        height="24">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M15.366 3.438L18.577 9H22v2h-1.167l-.757 9.083a1 1 0 0 1-.996.917H4.92a1 1 0 0 1-.996-.917L3.166 11H2V9h3.422l3.212-5.562 1.732 1L7.732 9h8.535l-2.633-4.562 1.732-1zM13 13h-2v4h2v-4zm-4 0H7v4h2v-4zm8 0h-2v4h2v-4z" />
                    </svg>
                </div>
                <h1 class="font-semibold text-gray-700">TOTAL ORDERS</h1>
                <h1 class="font-semibold mt-3 text-3xl text-green-700">{{$orders}}</h1>
            </div>
            <div class="bg-white relative border rounded-2xl p-4">
                <div class="absolute -top-7 h-10 w-10 rounded-xl grid place-content-center bg-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-white" width="24"
                        height="24">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M20.083 10.5l1.202.721a.5.5 0 0 1 0 .858L12 17.65l-9.285-5.571a.5.5 0 0 1 0-.858l1.202-.721L12 15.35l8.083-4.85zm0 4.7l1.202.721a.5.5 0 0 1 0 .858l-8.77 5.262a1 1 0 0 1-1.03 0l-8.77-5.262a.5.5 0 0 1 0-.858l1.202-.721L12 20.05l8.083-4.85zM12.514 1.309l8.771 5.262a.5.5 0 0 1 0 .858L12 13 2.715 7.429a.5.5 0 0 1 0-.858l8.77-5.262a1 1 0 0 1 1.03 0z" />
                    </svg>
                </div>
                <h1 class="font-semibold text-gray-700">TOTAL CATEGORIES</h1>
                <h1 class="font-semibold mt-3 text-3xl text-green-700">{{$categories}}</h1>
            </div>
            <div class="bg-white relative border rounded-2xl p-4">
                <div class="absolute -top-7 h-10 w-10 rounded-xl grid place-content-center bg-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-white" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M15.5 2a3.5 3.5 0 0 1 3.437 4.163l-.015.066a4.502 4.502 0 0 1 .303 8.428l-1.086 6.507a1 1 0 0 1-.986.836H6.847a1 1 0 0 1-.986-.836l-1.029-6.17a3 3 0 0 1-.829-5.824L4 9a6 6 0 0 1 8.575-5.42A3.493 3.493 0 0 1 15.5 2zM11 15H9v5h2v-5zm4 0h-2v5h2v-5zm2.5-2a2.5 2.5 0 1 0-.956-4.81l-.175.081a2 2 0 0 1-2.663-.804l-.07-.137A4 4 0 0 0 10 5C7.858 5 6.109 6.684 6.005 8.767L6 8.964l.003.17a2 2 0 0 1-1.186 1.863l-.15.059A1.001 1.001 0 0 0 5 13h12.5z" />
                    </svg>
                </div>
                <h1 class="font-semibold text-gray-700">TOTAL FOOD</h1>
                <h1 class="font-semibold mt-3 text-3xl text-green-700">{{$foods}}</h1>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h1 class="text-lg">Orders List</h1>
        <div class="mt-2 ">
            {{-- {{$this->table}} --}}
        </div>
    </div>
    <div class="fixed right-0 top-0 bottom-0 bg-gray-200 py-8 px-5 w-72">
        <div class="flex bg-white justify-between p-4 rounded-2xl">
            <div class="bg-blue-300 h-12 w-12 rounded-lg">sd</div>
            <div class="flex-1 px-2">
                <h1>JANE DOE</h1>
            </div>
        </div>
    </div>
</div>
