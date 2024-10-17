let user_ids = [];
document.querySelectorAll('#usercheckbox').forEach(function(checkbox){
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            console.log(this.value);
            user_ids.push(this.value);
            console.log('Checkbox is checked');
            document.getElementById('usercheckbox').value = 'true';
            console.log(user_ids);
        }
        if(!this.checked) {
            console.log(this.value);
            user_ids = user_ids.filter(id => id !== this.value);

            console.log('Checkbox is not checked');
            document.getElementById('usercheckbox').value = 'false';
        }
    });
})
window.confirmDelete = function(formid) {
    const form = document.getElementById(formid);
    document.getElementById('deleteConfirmationModal').classList.remove('hidden');
    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deleteConfirmationModal').classList.add('hidden');
    });
    document.getElementById('confirmDelete').addEventListener('click', function() {
        document.getElementById('user_ids').value = user_ids.join(',');
        form.submit();
    });
}



