<!-- কুইক ট্রানজেকশন মোডাল -->
<div class="modal fade" id="quickTransactionModal" tabindex="-1" aria-labelledby="quickTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #E4BE06;">
                <h5 class="modal-title" id="quickTransactionModalLabel">
                    <span id="modalTitle"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="quickTransactionAlert" class="alert d-none"></div>
                
                <form id="quickTransactionForm" action="{{ route('transactions.quick-add') }}" method="POST" class="pb-2">
                    @csrf
                    <input type="hidden" name="type" id="transactionType">
                    
                    <div class="mb-3">
                        <label for="amount" class="form-label">পরিমাণ <span style="color: #FE5B56;">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="background-color: #E4BE06; color: #212529; border-color: #E4BE06;">৳</span>
                            <input type="number" class="form-control" id="amount" name="amount" required min="0" step="0.01" style="border-color: #E4BE06;">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="account_id" class="form-label">হিসাব <span style="color: #FE5B56;">*</span></label>
                        <select class="form-select" id="account_id" name="account_id" required style="border-color: #E4BE06;">
                            <option value="">হিসাব নির্বাচন করুন</option>
                            @foreach(App\Models\Account::where('user_id', Auth::id())->get() as $account)
                                <option value="{{ $account->id }}">{{ $account->name }} (৳{{ number_format($account->current_balance, 2) }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3" id="categorySelectContainer">
                        <label for="category_id" class="form-label">বিভাগ <span style="color: #FE5B56;">*</span></label>
                        <select class="form-select" id="category_id" name="category_id" required style="border-color: #E4BE06;">
                            <option value="">বিভাগ নির্বাচন করুন</option>
                            
                            <!-- ইনকাম ক্যাটেগরি (আয় বিভাগ) -->
                            <optgroup label="আয়ের বিভাগ" id="income-categories" style="display: none;">
                                @foreach(App\Models\Category::where('user_id', Auth::id())->where('type', 'income')->orderBy('name')->get() as $category)
                                    <option value="{{ $category->id }}" data-type="income">{{ $category->name }}</option>
                                @endforeach
                                <option value="new_income_category" data-type="income">+ নতুন আয়ের বিভাগ</option>
                            </optgroup>
                            
                            <!-- এক্সপেন্স ক্যাটেগরি (ব্যয় বিভাগ) -->
                            <optgroup label="ব্যয়ের বিভাগ" id="expense-categories" style="display: none;">
                                @foreach(App\Models\Category::where('user_id', Auth::id())->where('type', 'expense')->orderBy('name')->get() as $category)
                                    <option value="{{ $category->id }}" data-type="expense">{{ $category->name }}</option>
                                @endforeach
                                <option value="new_expense_category" data-type="expense">+ নতুন ব্যয়ের বিভাগ</option>
                            </optgroup>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="newCategoryDiv" style="display: none;">
                        <label for="category_name" class="form-label">নতুন বিভাগের নাম <span style="color: #FE5B56;">*</span></label>
                        <input type="text" class="form-control" id="category_name" name="category_name" style="border-color: #E4BE06;">
                    </div>
                    
                    <div class="mb-3">
                        <label for="note" class="form-label">বিবরণ</label>
                        <textarea class="form-control" id="note" name="note" rows="2" style="border-color: #E4BE06;"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="transaction_date" class="form-label">তারিখ <span style="color: #FE5B56;">*</span></label>
                        <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}" required style="border-color: #E4BE06;">
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary" id="saveBtn" style="background-color: #FE5B56; border-color: #FE5B56;">
                            <i class="fas fa-save me-1"></i> সংরক্ষণ করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- জাভাস্ক্রিপ্ট -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // মোডাল ইনিশিয়ালাইজেশন
        const quickTransactionModal = new bootstrap.Modal(document.getElementById('quickTransactionModal'));
        const quickTransactionModalEl = document.getElementById('quickTransactionModal');
        const quickTransactionForm = document.getElementById('quickTransactionForm');
        const quickTransactionAlert = document.getElementById('quickTransactionAlert');
        
        // আয়/ব্যয় বিভাগ লোড করার ইভেন্ট
        if (quickTransactionModalEl) {
            // আগের ইভেন্ট লিসেনার রিমুভ করা
            quickTransactionModalEl.removeEventListener('show.bs.modal', handleModalShow);
            // নতুন ইভেন্ট লিসেনার যোগ করা
            quickTransactionModalEl.addEventListener('show.bs.modal', handleModalShow);
        }
        
        // মোডাল শো হ্যান্ডলার ফাংশন
        function handleModalShow(event) {
                // ট্রিগার বাটন থেকে ডাটা টাইপ নেওয়া
                const button = event.relatedTarget;
                if (button) {
                    const type = button.getAttribute('data-type');
                    console.log('Modal opened with type:', type);
                    
                    if (type) {
                        // টাইটেল সেট করা
                        const title = type === 'income' ? 'আয় যোগ করুন' : 'ব্যয় যোগ করুন';
                        document.getElementById('modalTitle').textContent = title;
                        document.getElementById('transactionType').value = type;
                        
                        // ফর্ম রিসেট
                        document.getElementById('quickTransactionForm').reset();
                        document.getElementById('transaction_date').value = getFormattedDate();
                        
                    // অ্যালার্ট হাইড করা
                    quickTransactionAlert.classList.add('d-none');
                    
                    // সঠিক ক্যাটেগরি গ্রুপ দেখানো
                    showCategoryGroup(type);
                }
            }
        }
        
        // সঠিক ক্যাটেগরি গ্রুপ দেখানোর ফাংশন
        function showCategoryGroup(type) {
            const incomeCategories = document.getElementById('income-categories');
            const expenseCategories = document.getElementById('expense-categories');
            
            if (type === 'income') {
                incomeCategories.style.display = 'block';
                expenseCategories.style.display = 'none';
                console.log('আয়ের বিভাগ দেখানো হচ্ছে');
            } else {
                incomeCategories.style.display = 'none';
                expenseCategories.style.display = 'block';
                console.log('ব্যয়ের বিভাগ দেখানো হচ্ছে');
            }
            
            // নতুন বিভাগ ইনপুট লুকিয়ে রাখা
            document.getElementById('newCategoryDiv').style.display = 'none';
        }
        
        // ক্যাটেগরি সিলেক্ট চেঞ্জ ইভেন্ট
        document.getElementById('category_id').addEventListener('change', function() {
            const selectedValue = this.value;
            const newCategoryDiv = document.getElementById('newCategoryDiv');
            
            // নতুন বিভাগ টাইপ চেক করা
            if (selectedValue === 'new_income_category' || selectedValue === 'new_expense_category') {
                newCategoryDiv.style.display = 'block';
                document.getElementById('category_name').required = true;
                document.getElementById('category_name').focus();
            } else {
                newCategoryDiv.style.display = 'none';
                document.getElementById('category_name').required = false;
            }
        });
        
        // ফর্ম সাবমিট ইভেন্ট লিসেনার
        if (quickTransactionForm) {
            // ডুপ্লিকেট ইভেন্ট লিসেনার এড়াতে আগে থাকা লিসেনার রিমুভ করা
            quickTransactionForm.removeEventListener('submit', handleFormSubmit);
            // নতুন ইভেন্ট লিসেনার যোগ করা
            quickTransactionForm.addEventListener('submit', handleFormSubmit);
        }
        
        // ফর্ম সাবমিট হ্যান্ডলার ফাংশন
        function handleFormSubmit(e) {
            e.preventDefault();
            
            // ডাবল সাবমিশন এড়াতে চেক করা
            const submitButton = document.getElementById('saveBtn');
            if (submitButton.disabled) {
                console.log('ফর্ম ইতিমধ্যে সাবমিট হচ্ছে, অপেক্ষা করুন...');
                return;
            }
            
            const formData = new FormData(this);
            const type = document.getElementById('transactionType').value;
            
            // বাটন লোডিং স্টেট
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> অপেক্ষা করুন...';
            
            // ক্যাটেগরি চেক করা
            const categorySelect = document.getElementById('category_id');
            const selectedCategory = categorySelect.value;
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            
            console.log('সিলেক্টেড ক্যাটেগরি:', selectedCategory);
            console.log('ক্যাটেগরি অপশন:', selectedOption);
            
            // সিলেক্টেড ক্যাটেগরি চেক করা
            if (selectedCategory) {
                // নতুন ক্যাটেগরি তৈরির অপশন চেক করা
                if (selectedCategory === 'new_income_category' || selectedCategory === 'new_expense_category') {
                    const categoryName = document.getElementById('category_name').value.trim();
                    if (!categoryName) {
                        // ক্যাটেগরি নাম বাধ্যতামূলক
                        quickTransactionAlert.textContent = 'অনুগ্রহ করে বিভাগের নাম লিখুন।';
                        quickTransactionAlert.classList.remove('d-none', 'alert-success');
                        quickTransactionAlert.classList.add('alert-danger');
                        
                        // বাটন রিসেট
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<i class="fas fa-save me-1"></i> সংরক্ষণ করুন';
                        return;
                    }
                    
                    // পাঠানোর জন্য ক্যাটেগরি নাম সেট করা
                    formData.set('category_name', categoryName);
                    formData.delete('category_id');
                }
                // যদি ডিফল্ট ক্যাটেগরি সিলেক্ট করা হয়, তাহলে ক্যাটেগরি নাম ব্যবহার করা
                else if (selectedOption && selectedOption.dataset.isDefault === 'true') {
                    console.log('ডিফল্ট ক্যাটেগরি সিলেক্ট করা হয়েছে');
                    // ক্যাটেগরি নাম এবং টাইপ পাঠানো
                    formData.set('category_name', selectedOption.textContent);
                    formData.delete('category_id');
                } 
                // যদি সার্ভার থেকে লোড করা ক্যাটেগরি হয় এবং টাইপ মিলে না যায়
                else if (selectedOption && selectedOption.dataset.type && selectedOption.dataset.type !== type) {
                    console.log('ক্যাটেগরি টাইপ মিলছে না:', selectedOption.dataset.type, type);
                    // ক্যাটেগরি নাম এবং টাইপ পাঠানো
                    formData.set('category_name', selectedOption.textContent);
                    formData.delete('category_id');
                }
                // যদি সিলেক্টেড ক্যাটেগরি আইডি না হয়, তাহলে নাম হিসেবে পাঠানো
                else if (isNaN(parseInt(selectedCategory))) {
                    console.log('ক্যাটেগরি আইডি নয়, নাম হিসেবে পাঠানো হচ্ছে');
                    formData.set('category_name', selectedCategory);
                    formData.delete('category_id');
                }
            } else {
                // ক্যাটেগরি সিলেক্ট না করলে এরর দেখানো
                quickTransactionAlert.textContent = 'অনুগ্রহ করে একটি বিভাগ নির্বাচন করুন।';
                quickTransactionAlert.classList.remove('d-none', 'alert-success');
                quickTransactionAlert.classList.add('alert-danger');
                
                // বাটন রিসেট
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-save me-1"></i> সংরক্ষণ করুন';
                return;
            }
            
            // AJAX কল
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // সফল হলে
                    quickTransactionAlert.textContent = data.message;
                    quickTransactionAlert.classList.remove('d-none', 'alert-danger');
                    quickTransactionAlert.classList.add('alert-success');
                    
                    // ১ সেকেন্ড পর মোডাল বন্ধ করা এবং পেজ রিলোড করা
                    setTimeout(() => {
                        quickTransactionModal.hide();
                        window.location.reload();
                    }, 1000);
                } else {
                    // ব্যর্থ হলে
                    quickTransactionAlert.textContent = data.message || 'লেনদেন যোগ করতে সমস্যা হয়েছে।';
                    quickTransactionAlert.classList.remove('d-none', 'alert-success');
                    quickTransactionAlert.classList.add('alert-danger');
                    
                    // বাটন রিসেট
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-save me-1"></i> সংরক্ষণ করুন';
                }
            })
            .catch(error => {
                console.error('লেনদেন যোগ করতে সমস্যা হয়েছে:', error);
                
                // এরর মেসেজ দেখানো
                quickTransactionAlert.textContent = 'লেনদেন যোগ করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।';
                quickTransactionAlert.classList.remove('d-none', 'alert-success');
                quickTransactionAlert.classList.add('alert-danger');
                
                // বাটন রিসেট
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-save me-1"></i> সংরক্ষণ করুন';
            });
        }
        
        // কুইক ট্রানজেকশন বাটন ইভেন্ট লিসেনার
        document.querySelectorAll('.quick-transaction-btn').forEach(button => {
            // ডুপ্লিকেট ইভেন্ট লিসেনার এড়াতে পুরানো বাটন রিপ্লেস করা
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
        });
        
        // নতুন বাটনে ইভেন্ট লিসেনার যোগ করা
        document.querySelectorAll('.quick-transaction-btn').forEach(button => {
            button.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                console.log('Quick transaction button clicked:', type);
                
                // টাইটেল সেট করা
                const title = type === 'income' ? 'আয় যোগ করুন' : 'ব্যয় যোগ করুন';
                document.getElementById('modalTitle').textContent = title;
                document.getElementById('transactionType').value = type;
                
                // ফর্ম রিসেট
                document.getElementById('quickTransactionForm').reset();
                document.getElementById('transaction_date').value = getFormattedDate();
                
                // সঠিক ক্যাটেগরি গ্রুপ দেখানো
                showCategoryGroup(type);
            });
        });
        
        // আজকের তারিখ ফরম্যাট করার ফাংশন
        function getFormattedDate() {
            const today = new Date();
            const year = today.getFullYear();
            let month = today.getMonth() + 1;
            let day = today.getDate();
            
            month = month < 10 ? '0' + month : month;
            day = day < 10 ? '0' + day : day;
            
            return `${year}-${month}-${day}`;
        }
    });
</script>
@endpush 