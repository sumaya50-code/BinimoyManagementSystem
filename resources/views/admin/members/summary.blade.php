@extends('admin.partials.index')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Member Profile Summary</h1>
            <p class="text-slate-500 mt-1">Quick overview of members with key counts and links to their profile.</p>
        </div>

        <a href="{{ route('members.index') }}" class="px-4 py-2 rounded-lg bg-slate-700 hover:bg-slate-900 text-white shadow">
            ← Back to Members
        </a>
    </div>

    <div class="card shadow-md rounded-xl p-6">
        <div class="overflow-x-auto">
            <table id="membersSummaryTable" class="w-full border rounded overflow-hidden table-auto">
                <thead class="bg-slate-100 text-left">
                    <tr>
                        <th class="py-2 px-3">Member No</th>
                        <th class="py-2 px-3">Name</th>

                        <th class="py-2 px-3">NID</th>
                        <th class="py-2 px-3">Phone</th>

                        <th class="py-2 px-3">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof $ === 'undefined' || !$.fn.dataTable) {
                    console.warn('DataTables or jQuery not loaded.');
                    return;
                }

                $('#membersSummaryTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('members.summary.data') }}',
                        type: 'GET'
                    },
                    columns: [{
                            data: 'member_no',
                            name: 'member_no'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },

                        {
                            data: 'nid',
                            name: 'nid'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },

                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [
                        [0, 'asc']
                    ],
                    pageLength: 25,
                });
            });
        </script>
    </div>
@endsection
