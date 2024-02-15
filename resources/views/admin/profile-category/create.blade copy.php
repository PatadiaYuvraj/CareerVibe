@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Add Profile Category
                    </span>
                    <a href="{{ route('admin.profile-category.index') }}" class="float-end btn btn-sm btn-primary">
                        Back
                    </a>
                </div>
                <div class="card-body">
                    {{-- <form method="POST" action="{{ route('admin.profile-category.store') }}"> --}}
                    <form id="profile-category-form" method="POST" action="{{ route('admin.profile-category.store') }}">
                        @csrf
                        <div class="form-group mb-3" id="profile-categories">
                            <div class="row">
                                <label for="name">Name 1</label>
                                <div class="input-group mb-2">
                                    <input type="text" name="name[]" id="name" class="form-control col">
                                    {{-- <button type="button" class="btn btn-danger col-2">Delete</button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <button type="button" id="add-category" class="btn btn-primary">Add</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            @if ($errors->any())

                <div class="alert alert-danger">
                    <ul>

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        const profileCategoriesContainer = document.getElementById('profile-categories');
        const addCategoryButton = document.getElementById('add-category');

        function createCategoryField() {
            const categoryField = document.createElement('div');
            categoryField.classList.add('row', 'mb-32');

            const nameLabel = document.createElement('label');
            nameLabel.setAttribute('for', 'name');
            nameLabel.textContent = `Name ${profileCategoriesContainer.children.length + 1}`;
            categoryField.appendChild(nameLabel);

            // const nameInput = document.createElement('input');
            // nameInput.type = 'text';
            // nameInput.name = 'name[]';
            // nameInput.id = 'name';
            // nameInput.classList.add('form-control', 'col');
            // categoryField.appendChild(nameInput);

            // const deleteButton = document.createElement('button');
            // deleteButton.type = 'button';
            // deleteButton.classList.add('btn', 'btn-danger', 'col-2');
            // deleteButton.textContent = 'Delete';
            // deleteButton.addEventListener('click', () => {
            //     categoryField.remove();
            // });


            // categoryField.appendChild(deleteButton);

            const innerDiv = document.createElement('div');
            innerDiv.classList.add('input-group', 'col', 'mb-3');
            const nameInput = document.createElement('input');
            nameInput.type = 'text';
            nameInput.name = 'name[]';
            nameInput.id = 'name';
            nameInput.classList.add('form-control', 'col');
            innerDiv.appendChild(nameInput);
            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'col-2');
            deleteButton.textContent = 'Delete';

            deleteButton.addEventListener('click', () => {
                categoryField.remove();
            });
            innerDiv.appendChild(deleteButton);
            categoryField.appendChild(innerDiv);


            return categoryField;
        }

        addCategoryButton.addEventListener('click', () => {
            const newCategoryField = createCategoryField();
            profileCategoriesContainer.appendChild(newCategoryField);
        });

        document.getElementById('profile-category-form').addEventListener('submit', (e) => {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            fetch(form.action, {

                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Profile Category Created Successfully');
                        form.reset();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
