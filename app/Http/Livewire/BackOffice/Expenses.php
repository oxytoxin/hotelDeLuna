<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\ExpenseCategory;
use App\Models\Expense;

class Expenses extends Component
{
    use Actions;
    public $create_modal = false;
    public $add_expense_modal = false;
    public $category_name;
    public $expense_name;
    public $expense_amount;
    public $expense_category_id;
    public $expense_description;

    public function render()
    {
        return view('livewire.back-office.expenses', [
            'categories' => ExpenseCategory::get(),
            'expenses' => Expense::with('expense_category')->get(),
        ]);
    }

    public function saveCategory()
    {
        $this->validate([
            'category_name' => 'required',
        ]);
        ExpenseCategory::create([
            'name' => $this->category_name,
            'branch_id' => auth()->user()->branch_id,
        ]);
        $this->notification()->success(
            $title = 'Category added',
            $description = 'The category has been added successfully.'
        );
        $this->category_name = '';
    }

    public function saveExpense()
    {
        $this->validate([
            'expense_name' => 'required',
            'expense_amount' => 'required',
            'expense_category_id' => 'required',
            'expense_description' => 'required',
        ]);
        Expense::create([
            'name' => $this->expense_name,
            'amount' => $this->expense_amount,
            'expense_category_id' => $this->expense_category_id,
            'description' => $this->expense_description,
        ]);
        $this->notification()->success(
            $title = 'Expense added',
            $description = 'The expense has been added successfully.'
        );
        $this->expense_name = '';
        $this->expense_amount = '';
        $this->expense_category_id = '';
        $this->expense_description = '';

        $this->add_expense_modal = false;
    }
}
