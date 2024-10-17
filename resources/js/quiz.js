const questionsContainer = document.getElementById('questionsContainer');
const formContainer = document.getElementById('quizForm');
    let questionCounter = 0;
    let mcq= 0;
    let online = 0;
    let multians = 0;
    let truefalse = 0;


    document.getElementById('addQuestionBtn').addEventListener('click',function(){
        let questionHtml = '';
        let page = this.getAttribute('page');
        console.log(page)
        let type = document.getElementById('addQuestionOption').value;
        // let number = document.getElementById('numberOfQuestions').value;
        console.log(type)
       

        // True or False Component
        if (type === 'truefalse') {
            truefalse++;
            questionHtml = `
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" id="truefalse${truefalse}">
                    <label class="flex justify-between text-lg font-medium text-gray-700 mb-2">True or False
                    <input type="number" name="ques[truefalse][${truefalse}][marks]" placeholder="marks" class="w-24 border border-gray-300 rounded-lg px-2 py-1 mb-4">
                    <button class="text-red-700" onclick="removeQuestion('truefalse${truefalse}')">
                    <svg class="delete cursor-pointer" width="18px" height="18px" viewBox="0 0 24 24" fill="currentcolor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                        d="M6 5H18M9 5V5C10.5769 3.16026 13.4231 3.16026 15 5V5M9 20H15C16.1046 20 17 19.1046 17 18V9C17 8.44772 16.5523 8 16 8H8C7.44772 8 7 8.44772 7 9V18C7 19.1046 7.89543 20 9 20Z"
                        stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
                    </label>
                    <input type="text" name="ques[truefalse][${truefalse}][question]" placeholder="Enter question" class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="ques[truefalse][${truefalse}][ans]" value="1" class="form-radio text-indigo-500">
                            <span class="ml-2">True</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="ques[truefalse][${truefalse}][ans]" value="0" class="form-radio text-indigo-500">
                            <span class="ml-2">False</span>
                        </label>
                        
                    </div>
                </div>
            `;
            
        }

        // Oneline Component (Question/Answer)
        if (type === 'oneline') {
            online++;
            questionHtml = `
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" id="online${online}">
                    <label class="flex  justify-between text-lg font-medium text-gray-700 mb-2">Question/Answer
                    <input type="number" name="ques[oneline][${online}][marks]" placeholder="marks" class="w-24 border border-gray-300 rounded-lg px-2 py-1 mb-4">
                    <button class="text-red-700" onclick="removeQuestion('online${online}')">
                    <svg class="delete cursor-pointer" width="18px" height="18px" viewBox="0 0 24 24" fill="currentcolor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                        d="M6 5H18M9 5V5C10.5769 3.16026 13.4231 3.16026 15 5V5M9 20H15C16.1046 20 17 19.1046 17 18V9C17 8.44772 16.5523 8 16 8H8C7.44772 8 7 8.44772 7 9V18C7 19.1046 7.89543 20 9 20Z"
                        stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
                    </label>
                    <input type="text" name="ques[oneline][${online}][question]" placeholder="Enter question" class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                    <input type="text" name="ques[oneline][${online}][ans]" placeholder="Enter answer" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                </div>
            `;
            // oneline++;
        }

        // MCQ (Single Answer)
        if (type === 'mcq') {
            mcq++;
            
            questionHtml = `
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" id="mcq${mcq}">
                    <label class="flex justify-between text-lg font-medium text-gray-700 mb-2">Multiple Choice (One Answer)
                    <input type="number" name="ques[mcq][${mcq}][marks]" placeholder="marks" class="w-24 border border-gray-300 rounded-lg px-2 py-1 mb-4">
                        <button class="text-red-700" onclick="removeQuestion('mcq${mcq}')">
                            <svg class="delete cursor-pointer" width="18px" height="18px" viewBox="0 0 24 24" fill="currentcolor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                d="M6 5H18M9 5V5C10.5769 3.16026 13.4231 3.16026 15 5V5M9 20H15C16.1046 20 17 19.1046 17 18V9C17 8.44772 16.5523 8 16 8H8C7.44772 8 7 8.44772 7 9V18C7 19.1046 7.89543 20 9 20Z"
                                stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </label>
                    <input type="text" name="ques[mcq][${mcq}][question]" placeholder="Enter question" class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                    <div class="space-y-2">
                        <input type="text" name="ques[mcq][${mcq}][opt][1]" placeholder="Option 1" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <input type="text" name="ques[mcq][${mcq}][opt][2]" placeholder="Option 2" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <input type="text" name="ques[mcq][${mcq}][opt][3]" placeholder="Option 3" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <input type="text" name="ques[mcq][${mcq}][opt][4]" placeholder="Option 4" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div class="mt-4">
                        <label for="mcq_correct" class="block text-sm font-medium text-gray-700">Correct Answer (1-4)</label>
                        <input type="number" name="ques[mcq][${mcq}][ans]" min="1" max="4" placeholder="Enter correct option number" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                </div>
            `;
            // mcq++;
        }

        // Multiple Answer (Multi Correct)
        if (type === 'multians') {
            multians++;
            questionHtml = `
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" id="multians${multians}">
                    <label class="flex justify-between text-lg font-medium text-gray-700 mb-2">Multiple Choice (Multiple Answers..) 
                    <input type="number" name="ques[multians][${multians}][marks]" placeholder="marks" class=" w-24 border border-gray-300 rounded-lg px-2 py-1 mb-4">
                    <button class="text-red-700" onclick="removeQuestion('multians${multians}')">
                        <svg class="delete cursor-pointer" width="18px" height="18px" viewBox="0 0 24 24" fill="currentcolor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                            d="M6 5H18M9 5V5C10.5769 3.16026 13.4231 3.16026 15 5V5M9 20H15C16.1046 20 17 19.1046 17 18V9C17 8.44772 16.5523 8 16 8H8C7.44772 8 7 8.44772 7 9V18C7 19.1046 7.89543 20 9 20Z"
                            stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    </label>
                    <input type="text" name="ques[multians][${multians}][question]" placeholder="Enter question" class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="ques[multians][${multians}][choice][1]" value="1" class="form-checkbox text-indigo-500">
                            <span class="ml-2">Option 1</span>
                        </label>
                        <input type="text" name="ques[multians][${multians}][opt][1]" placeholder="Option 1" class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="ques[multians][${multians}][choice][2]" value="2" class="form-checkbox text-indigo-500">
                            <span class="ml-2">Option 2</span>
                        </label>
                        <input type="text" name="ques[multians][${multians}][opt][2]" placeholder="Option 2" class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="ques[multians][${multians}][choice][3]" value="3" class="form-checkbox text-indigo-500">
                            <span class="ml-2">Option 3</span>
                        </label>
                        <input type="text" name="ques[multians][${multians}][opt][3]" placeholder="Option 3" class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="ques[multians][${multians}][choice][4]" value="4" class="form-checkbox text-indigo-500">
                            <span class="ml-2">Option 4</span>
                        </label>
                        <input type="text" name="ques[multians][${multians}][opt][4]" placeholder="Option 4" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                </div>
            `;
            // multians++;
        }
        if(page==null){
            questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
        }
        if(page==='edit'){
            formContainer.insertAdjacentHTML('beforeend', questionHtml);
        }

    })
    // function addQuestion() {
        
        
        

    // }

    function removeQuestion(id){
        document.querySelector('#'+id).remove();
    }

    window.removeQuestion = removeQuestion;