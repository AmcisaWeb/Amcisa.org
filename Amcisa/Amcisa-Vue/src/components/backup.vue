<template>
<div>
  <input
    v-model="newTodoText"
    v-on:keyup.enter="addNewTodo"
    placeholder="Add a todo"
  >
  <ul>
    <li
      is="todo-item"
      v-for="(todo, index) in todos"
      v-bind:key="todo.id"
      v-bind:title="todo.title"
      v-on:remove="todos.splice(index, 1)"
    ></li>
  </ul>
  {{todos[0].title}}
  {{xx.name}}
  {{event_data.fill_in[0].field.type}}
</div>
</template>

<script>
  export default {
    data(){
      return {
        strData: '{"name": "AmTee",\
                   "id": "1",\
                   "state": "1",\
                   "description": "This is an event to submit T-shirt",\
                   "role": "member",\
                   "fill_in": [\
                      {"field":{"type": "description", "content": "Please elect the most Tee design U like!"}},\
                      {"field":{"type": "image", "content": "Design 1", "path": ""}},\
                      {"field":"sadasd"}\
                   ]}',
        xx: '',
        newTodoText: '',
        todos: [
          {
            id: 1,
            title: 'Do the dishes',
          },
          {
            id: 2,
            title: 'Take out the trash',
          },
          {
            id: 3,
            title: 'Mow the lawn'
          }
        ],
        event_data:{
          name: 'AmTee',
          id: '1',
          state: '1',
          description: 'This is an event to submit T-shirt',
          role: 'member',
          fill_in: [
            {field: {type:'description', content:'Please elect the most Tee design U like!'}},
            {field: {type:'description', content:'Please elect the most Tee design U like!'}},
            {field: {type:'description', content:'Please elect the most Tee design U like!'}}
          ]
        },
        nextTodoId: 4
      }

    },
    methods: {
      addNewTodo: function () {
        this.todos.push({
          id: this.nextTodoId++,
          title: this.newTodoText
        })
        this.newTodoText = ''
      }
    },
    components: {
      'todo-item': {
        template: '\
        <li>\
          {{ title }}\
          <button v-on:click="$emit(\'remove\')">X</button>\
        </li>\
        ',
        props: ['title']
      }
    },
    mounted: function () {
      console.log(JSON.parse(this.strData));
      this.xx = JSON.parse(this.strData);
      prototype.$appName = 'My App';
      console.log(this.$appName);
    }
  }
</script>
