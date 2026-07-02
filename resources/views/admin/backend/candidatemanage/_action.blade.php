<x-edit-button href="{{ route('jobmanage.edit', $jobPost->id) }}" class="btn btn-icon btn-sm btn-info" title="Edit">
    <i class="ti ti-edit"></i>
</x-edit-button>


<x-delete-button href="#" class=" btn btn-icon btn-sm btn-danger deleteBtn"
    data-url="{{ route('jobmanage.destroy', $jobPost->id) }}" style="background-color: red" title="Delete">
    <i class="ti ti-trash"></i>
</x-delete-button>