window.deleteModule = function(course_id, module_id) {
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenElement ? csrfTokenElement.getAttribute('content') : null;
    if (!csrfToken) {
        console.error("CSRF token not found. Cannot send request.");
        return;
    }
    fetch(`/module/delete`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            course_id: course_id,
            module_id: module_id,
        })
    });
    setTimeout(() => {
        location.reload();
    }, 1000);
}

window. addModule =function() {
    const addModuleBtn = document.getElementById('add-submodule');
    addModuleBtn.setAttribute('counter', 1);
    const counter = parseInt(addModuleBtn.getAttribute('counter'));
    if (counter > 0) {
        document.querySelector('#moduleSubmitBtn').classList.remove('hidden');
    }

    const modules = document.getElementById('modules');
    const count = parseInt(modules.getAttribute('count'));
    const element = document.createElement('div');
    element.innerHTML =

        `<div class="module${count+1} relative p-8 flex items-center justify-between">
            <div class="blueline absolute bg-blue-500 h-[90%] w-2 rounded-l-sm left-1"></div>
            <div class="moduleid absolute top-2">
                <span>Module ${count+1}</span>
            </div>
            <input class="text-2xl font-semibold mb-6" name="module[${count+1}][title]" placeholder="Module Title">
    </div>`;
    modules.appendChild(element)
    modules.setAttribute('count', count + 1);

}