    <x-card title="Deposits">
        <x-transactions :headers="['Remarks', 'Amount', 'Deposit At']">
            <x-slot:body>
                @forelse ($deposits as $key => $deposit)
                    <tr wire:key="{{ $key . $deposit->id }}">
                        <x-transactions.cell>
                            {{ $deposit->remarks }}
                        </x-transactions.cell>
                        <x-transactions.cell>
                            {{ $deposit->amount }}
                        </x-transactions.cell>
                        <x-transactions.cell>
                            {{ $deposit->created_at->format('d M Y') }}
                        </x-transactions.cell>
                    </tr>
                @empty
                    <tr>
                        <x-transactions.cell colspan="5">
                            No transactions found
                        </x-transactions.cell>
                    </tr>
                @endforelse
            </x-slot:body>
        </x-transactions>
    </x-card>
