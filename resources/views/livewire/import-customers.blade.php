<div>
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <div class="col">
                <h4 class="card-title mb-0 flex-grow-1">Import Customer</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="uploadAndPrepareImport">
                <div class="form-group">
                    <label for="file">Upload File</label>
                    <input type="file" class="form-control" id="file" wire:model="upload_file">
                    @error('upload_file')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Prepare Import</button>
            </form>

            @if ($previewData)
            <div class="table-responsive mt-5">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            @foreach($headers as $header)
                            <th>
                                {{ $header }}
                                <select wire:model.lazy="selectedMappings.{{ $header }}">
                                    <option value="">Select Field</option>
                                    @foreach($columnOptions as $field => $label)
                                    <option value="{{ $field }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($previewData as $row)
                        <tr>
                            @foreach($row as $cell)
                            <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button wire:click="importData" class="btn btn-info mt-3">Import Data</button>
            <button wire:click="resetPreview" class="btn btn-secondary mt-3">Reset</button>
            @endif
        </div>
    </div>
</div>