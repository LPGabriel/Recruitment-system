<?php

namespace App\Livewire\Testes;

use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizResult;
use Exception;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Filament\Forms\Form as FormFilament;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class Form extends Component
{

    public Quiz $quiz;
    public $userAnswers = [];

    public function mount($slug)
    {
        $this->quiz = Quiz::where('slug', $slug)->with('questions.answers')->first();
    }

    public function save()
    {
        // $groupedData = array_count_values($this->userAnswers);

        try {
            $quiz_result = QuizResult::create([
                'quiz_id' => $this->quiz->id,
                'quiz_name' => $this->quiz->title,
                'quiz_system' => $this->quiz->quiz_system ?? "",
                'point_score' => '',
                'correct_score' => '',
                'correct' => '',
                'total' => 0,
                'user_id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'business' => auth()->user()->name,
                'email' => auth()->user()->email,
                'form_type' => 'quiz',
                'quiz_results' => $this->userAnswers,
            ]);
        } catch (Exception $e) {
            dd($e);
        }

        return redirect(route('teste-form', ['slug' => 'teste-disc']));
    }

    public function saveAnswer($questionId, $answerId)
    {
        $answer = QuizAnswer::find($answerId);

        $this->userAnswers[$questionId] = $answer->score;
    }


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.testes.form');
    }
}
