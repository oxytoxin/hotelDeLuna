    <x-card title="Deposits">
        <x-transactions :headers="['Remarks', 'Amount', 'Deposit At', 'Deduction', 'Retrived', 'To Claim', 'Actions']">
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
                        <x-transactions.cell>
                            ₱{{ $deposit->deducted ?? '0' }}
                        </x-transactions.cell>
                        <x-transactions.cell>
                            @if ($deposit->claimed_at)
                                {{ Carbon\Carbon::parse($deposit->claimed_at)->format('d M Y') }}
                            @else
                                'Not yet'
                            @endif
                        </x-transactions.cell>
                        <x-transactions.cell>
                            ₱{{ $deposit->amount - $deposit->deducted }}
                        </x-transactions.cell>
                        <x-transactions.cell>
                            <div class="flex space-x-3">
                                @if ($deposit->claimed_at)
                                    Claimed
                                @else
                                    <x-my.button-success label="Claim"
                                        py="py-1"
                                        x-on:click="$dispatch('confirm',{
                                title : 'Are you sure?',
                                message : 'Are you sure you want to proceed? Guest has PHP {{ $deposit->amount - $deposit->deducted }} left to claim.',
                                confirmButtonText : 'Confirm',
                                cancelButtonText : 'Cancel',
                                confirmMethod : 'claimDeposit',
                                confirmParams : {{ $deposit->id }}
                            })" />
                                @endif

                            </div>
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
