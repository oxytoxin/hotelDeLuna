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
    public $update_expense = false;
    public $update_id;
    public $employee_name;
    public $manage_employee = false;

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

    public function editCategory($id)
    {
        $query = ExpenseCategory::where('id', $id)->first();
        $this->update_expense = true;

        $this->update_id = $id;

        $this->category_name = $query->name;
    }

    public function updateCategory()
    {
        $this->validate([
            'category_name' => 'required',
        ]);
        ExpenseCategory::where('id', $this->update_id)->update([
            'name' => $this->category_name,
        ]);
        $this->notification()->success(
            $title = 'Category updated',
            $description = 'The category has been updated successfully.'
        );
        $this->category_name = '';
        $this->update_expense = false;
    }

    public function searchName()
    {
        $this->validate([
            'employee_name' => 'required',
        ]);

        $query = Expense::where('name', $this->employee_name)->get();
        if ($query->count() > 0) {
            $this->notification()->success(
                $title = 'Expense found',
                $description = 'The expense has been found successfully.'
            );
            $this->manage_employee = true;
        } else {
            $this->notification()->error(
                $title = 'Expense not found',
                $description = 'The expense has not been found.'
            );
        }
    }
}
