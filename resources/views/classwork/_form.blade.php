<x-block-error />
<x-alert />

<div class="row">
    <div class="col-md-8">
        <x-form.floating-control name="title" placeholder="Title">
            <x-form.input name="title" :value="$classwork->title" placeholder="Title" />
        </x-form.floating-control>

        <x-form.floating-control name="description" placeholder="Description">
            <x-form.textarea name="description" :value="$classwork->description" placeholder="Description" />
        </x-form.floating-control>
    </div>



    <div class="col-md-4">
        <div class="mb-3">
            @foreach ($classroom->students as $student)
                <div class="form-check">
                    <input name="students[]" class="form-check-input" type="checkbox" value="{{ $student->id }}"
                        id="std-{{ $student->id }}" @checked(!isset($assigned) || in_array($student->id, $assigned ?? []))>
                    <label class="form-check-label" for="std-{{ $student->id }}">
                        {{ $student->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <x-form.floating-control name="published_at" placeholder="published Date">
            <x-form.input type="date" :value="$classwork->published_date" name="due" min="0"
                placeholder="published  Date" />
        </x-form.floating-control>



        @if ($type == 'assignment')
            <x-form.floating-control name="options.grade" placeholder="Grade">
                <x-form.input type="number" :value="$classwork->options['grade'] ?? ''" name="options[grade]" min="0" placeholder="Grade" />
            </x-form.floating-control>

            <x-form.floating-control name="options.due" placeholder="Due Date">
                <x-form.input type="date" :value="$classwork->options['due'] ?? ''" name="options[due]" min="0" placeholder="Due Date" />
            </x-form.floating-control>
        @endif



        <!-- Topic Select -->
        <select class="form-select" name="topic_id" id="topic_id">
            <option value="">No Topic</option>
            @foreach ($classroom->topics as $topic)
                <option @selected($topic->id == $classwork->topic_id) value="{{ $topic->id }}">{{ $topic->name }}</option>
            @endforeach
        </select>
    </div>
</div>
