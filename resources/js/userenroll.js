const addingUserToCourseWindow = document.getElementById('enrollingUserToCourse');
const addUserToCourseBtn = document.getElementById('addUserToCourseBtn');
window.openAddingUserToCourseWindow = function () {
    addingUserToCourseWindow.classList.remove("hidden");
};

window.closeAddingUserToCourseWindow = function () {
    addingUserToCourseWindow.classList.add("hidden");
};


window.submitFiltering = function(bool,quiz){
    if(bool){
        document.getElementById('userFilterForm').submit();
    }
    if(quiz){
        document.getElementById('quizFilterForm').submit();
    }
    const filterForm = document.getElementById('filterForm');
    // const searchForm = document.getElementById('searchForm');
    const search = document.getElementById('exploreSearchBox');
    const category = document.getElementById('exploreCategoryFilter');
    const orderBy = document.getElementById('exploreOrderBy');
    search.value = search.value.trim();
    if(search.value.length > 0){

        window.location.href = filterForm.action + '?search=' + search.value + '&categoryFilter=' + category.value + '&orderBy=' + orderBy.value;
    }
    else{
        window.location.href = filterForm.action + '?categoryFilter=' + category.value + '&orderBy=' + orderBy.value;
    }
}



    // const dropdownButton = document.getElementById('roleDropdownButton');
    // const dropdownMenu = document.getElementById('roleDropdownMenu');

    // dropdownButton.addEventListener('click', () => {
    //     dropdownMenu.classList.toggle('hidden');
    // });

    // // Close the dropdown if clicked outside
    // window.addEventListener('click', function(e) {
    //     if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
    //         dropdownMenu.classList.add('hidden');
    //     }
    // });


window.changeSessionRole = function() {
        const switchRoleForm = document.getElementById('switch-role-form');
        switchRoleForm.submit();
    }
