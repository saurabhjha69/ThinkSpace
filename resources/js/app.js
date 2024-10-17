import "./bootstrap";


function showCustomPrivilege(){
    const customPrivilege = document.getElementsByClassName('custom-privilege');
    customPrivilege.classList.toggle('hidden');
}

const estPrice = document.getElementById('estimatedPrice');
const curPrice = document.getElementById('currentPrice');
const discount = document.getElementById('discount');
function calcDiscount(){
    const estimatedInput = estPrice.value;
    const currentInput = curPrice.value;
    const discountAmount = estimatedInput - currentInput;
    const discountedPrice = (discountAmount * 100 )/estimatedInput;
    if(discountedPrice < 0){

        discount.textContent = (discountedPrice.toFixed(2)*-1)+' % Accession!';
    }
    if(discountedPrice > 0){

        discount.textContent = discountedPrice.toFixed(2)+' % Discount!';
    }
}
estPrice.addEventListener('change',function(){
    if(curPrice.value!=''){
        calcDiscount();
    }
})
curPrice.addEventListener('change',function(){
    if(estPrice.value!=''){
        calcDiscount();
    }
})


//showCustomPrivilege()

// function showCustomPrivilege(){
//     const customPrivilege = document.getElementsByClassName('custom-privilege');
//     customPrivilege.classList.toggle('hidden');
// }

// window.global = showCustomPrivilege;

document.querySelector("#thumbnailUpload").addEventListener("change", function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById("thumbnailPreview");

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            preview.classList.add("hidden");
        }
    });

const predefinedArrows =document.querySelectorAll('.arrow')
    predefinedArrows.forEach(attachArrowListener);

function attachArrowListener(arrow) {
    arrow.addEventListener('click', function () {
        console.log("Arrow clicked")
        const submodule = arrow.getAttribute('parent');
        const submoduleContent = document.querySelector(`.submodule-content[parent="${submodule}"]`);
        if (submoduleContent) {
            console.log(submoduleContent);
            submoduleContent.classList.toggle("hidden");
        }
    });
}

function attachArrowListenerToModel(arrow) {
    arrow.addEventListener('click', function () {
        const module = arrow.getAttribute('parent');
        const moduleContent = document.querySelector(`.module-content[parent="${module}"]`);
        if (moduleContent) {
            moduleContent.classList.toggle("hidden");
        }
    });
}

// Delete submodule functionality
function attachDeleteListener(del) {
    del.addEventListener('click', function () {
        const parentValue = del.getAttribute('parent');
        const subModule = document.querySelector(`#${parentValue}`);
        if (subModule) subModule.remove();
        subModuleCounter--;
    });
}

function attachDeleteListenerToModel(del) {
    del.addEventListener('click', function () {
        const parentValue = del.getAttribute('parent');
        const module = document.querySelector(`#${parentValue}`);
        if (module) module.remove();
        moduleCounter--;
    });
}

// Common function to handle adding submodules
function attachSubModuleListener(button) {
    button.addEventListener("click", function () {
        const parent = this.getAttribute("parent");
        const subModulesDiv = document.querySelector(`.submodules[parent="${parent}"]`);
        if (!subModulesDiv) return;
        const submcount = parseInt(subModulesDiv.getAttribute('submcount'))+1;
        console.log(submcount);
        const newSubmodule = document.createElement("div");
        newSubmodule.classList.add("submodule", "mb-4", "rounded-md", "border", "border-gray-300", "p-5");
        newSubmodule.setAttribute("id", `m${submcount}`);
        newSubmodule.innerHTML = `
            <div class="submodule-tools w-full flex justify-between">
                <h4 class="text-lg font-semibold mb-2">Submodule ${submcount}</h4>
                <div class="dropdown flex">
                    <svg class="delete" parent="m${submcount}" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 5H18M9 5V5C10.5769 3.16026 13.4231 3.16026 15 5V5M9 20H15C16.1046 20 17 19.1046 17 18V9C17 8.44772 16.5523 8 16 8H8C7.44772 8 7 8.44772 7 9V18C7 19.1046 7.89543 20 9 20Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <svg class="arrow" parent="m${submcount}" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 6V18M12 18L7 13M12 18L17 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
            </div>
            <div class="submodule-content" parent="m${submcount}">
                <div class="mb-2">
                    <label class="block text-gray-700 font-bold mb-2">Submodule Title</label>
                    <input type="text" name="M[${moduleCounter}][S][${submcount}][title]" class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Submodule Title">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Video Upload</label>
                    <input type="file" name="M[${moduleCounter}][S][${submcount}][file]" class="w-full border border-gray-300 p-2 rounded-lg">
                </div>
            </div>`;

        subModulesDiv.appendChild(newSubmodule);
        attachArrowListener(newSubmodule.querySelector(".arrow"));
        attachDeleteListener(newSubmodule.querySelector(".delete"));
        submcount+1;
        subModulesDiv.setAttribute("submcount", submcount);
        console.log("Ans"+subModulesDiv.getAttribute("submcount"));
    });
}

// Initialize submodule counter
let subModuleCounter = 1;

// Attach listener to existing Add Submodule buttons
document.querySelectorAll(".addSubModule").forEach(button => attachSubModuleListener(button));
let moduleCounter;
moduleCounter = 0;
// Add module functionality
if(document.querySelector('.modules').getAttribute('module_count')){
    moduleCounter = parseInt(document.querySelector('.modules').getAttribute('module_count'));
}


document.querySelector(".addModule").addEventListener("click", function () {
    const parent = document.querySelector(".modules");
    const newModule = document.createElement("div");
    newModule.classList.add("module", "mb-6");
    newModule.setAttribute("id", `M${moduleCounter + 1}`);
    // newModule.setAttribute("subMCount", 0);
    newModule.innerHTML = `
        <div class="module-tools w-full flex justify-between">
            <h3 class="text-xl font-semibold mb-2">Module ${moduleCounter + 1}</h3>
            <div class="dropdown flex">
                <svg class="delete" parent="M${moduleCounter + 1}" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 5H18M9 5V5C10.5769 3.16026 13.4231 3.16026 15 5V5M9 20H15C16.1046 20 17 19.1046 17 18V9C17 8.44772 16.5523 8 16 8H8C7.44772 8 7 8.44772 7 9V18C7 19.1046 7.89543 20 9 20Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <svg class="arrow" parent="M${moduleCounter + 1}" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 6V18M12 18L7 13M12 18L17 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
        </div>
        <div class="module-content mb-4" parent="M${moduleCounter + 1}">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Module Title</label>
                <input type="text" name="M[${moduleCounter+1}][title]" class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Module Title">
            </div>
            
            <div class="submodules mb-4" parent="M${moduleCounter + 1}" submcount="0">
            </div>
            <p class="addSubModule bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded" parent="M${moduleCounter + 1}">Add Submodule</p>
        </div>
    `;

    parent.appendChild(newModule);

    attachArrowListenerToModel(newModule.querySelector(".arrow"));
    attachDeleteListenerToModel(newModule.querySelector(".delete"));
    attachSubModuleListener(newModule.querySelector(".addSubModule")); // Attach the listener to the new button
    moduleCounter++;
});


// team management

// function addIntro(){
//     document.getElementsByClassName('course_intro').classList.toggle("hidden");
// }




// quiz

