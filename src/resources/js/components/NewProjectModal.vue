<template>

<a style="margin-left:auto" class="button" id="myButton" >New Project</a>

<div id="myPopup" class="popup">
    <form @submit.prevent="submit">
        <div class="popup-content">
            <h1 style="font-size: medium;text-align:center">Lets start something new!</h1>
            <div style="display:flex">
                    <div style="flex:1;margin-right:10px">
                        <div>
                            <label for="title" style="font-size:small">Title</label>
                            <input v-model="form.title" type="text" id="title" style="padding:1px 2px;width:100%" :class="errors.title ? 'border_red' :'border_normal'">
                            <span style="font-size: xx-small; font-style: italic; color: red;" v-if="errors.title" v-text="errors.title[0]"></span>
                        </div>
                        <div>
                            <label for="title" style="font-size:small">Description</label>
                            <textarea v-model="form.description" type="text" id="description" style="padding:1px 2px;width:100%"></textarea>
                            <span style="font-size: xx-small; font-style: italic; color: red;" v-if="errors.description" v-text="errors.description[0]"></span>

                        </div>
                    </div>
                    <div style="flex:1;margin-left:10px">
                        <div id='input-cont'>
                            <label style="font-size:small">Need some tasks?</label>
                            <input 
                            type="text" 
                            style="padding:1px 2px;width:100%;margin-bottom:5px" 
                            placeholder="Task 1" 
                            v-for="task in form.tasks"
                            v-model="task.body">
                        </div>
                        <button type="button" @click="addTask" style="background-color:white;color:black;font-size:14px; padding-left:0;display: inline-flex;align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="15px" height="15px"><path d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z"/></svg>
                            <span>Add New Task Field</span>
                        </button>
                    </div>
                </div>
            <footer style="display: flex; justify-content: flex-end;">
                <button id="closePopup" style="margin-right:10px;background-color: white;  border-style: solid; border-color:#0d6efd; color:#0d6efd" type="button">
                    Cancel
                </button>
                <button>
                    Create Project
                </button>
            </footer>
        </div>
    </form>
</div>

</template>

<script>
// var inputCount = 1;
// var arraycout = 0;
// const container = document.getElementById('input-cont');
// const input = document.getElementById('input');


// function addTask() {
//     inputCount++; 
//     const clone = input.cloneNode(true);
//     clone.value = ' '
//     clone.placeholder = 'Task ' +  inputCount;
//     container.appendChild(clone);

// }

// function display() {
//     const tasks = [];
//     const data= [];
//     var k;


//     var array = document.getElementsByName('array[]');
//     for (var i = 0; i < array.length; i++) {
//         var a = array[i];
//         tasks[i] = a.value;

//     }
//     const dataelements = {
//     title: document.getElementById('title').value,
//     description: document.getElementById('description').value,
//     tasks: tasks,
//     }
//     data.push(dataelements);
//     console.log(data);

    
//     alert('submitted')

//     const btn = document.getElementById("submit");


// }
export default {
    data(){
        return {
            form:{
                title: '',
                description: '',
                tasks: [
                {body :''}
                
                ]
            },
            errors: {}
        };

    },
    methods: {
        addTask(){
            this.form.tasks.push({value: ''});
        },
        async submit(){
            try {
                let response = await axios.post('/projects',this.form)

                location = response.data.message;

            }catch(error){
                this.errors = (error.response.data.errors);
            }
            }
        
    },
    mounted(){
        myButton.addEventListener("click", function () {
            myPopup.classList.add("show");
        });
        closePopup.addEventListener("click", function () {
            myPopup.classList.remove("show");
        });
        window.addEventListener("click", function (event) {
            if (event.target == myPopup) {
                myPopup.classList.remove("show");
            }
        });
    }
}


</script>
