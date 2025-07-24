
<script setup>
import { reactive ,onMounted,computed} from 'vue'

defineProps(['message'])
import { ref } from 'vue'

const selected = ref('')
const dropdownValue = ref('')

const type=[
    {
        name:"Breeder seed",
        price:8
    },
     {
        name:"Foundation seed",
        price:5
    },
     {
        name:"Hybrid",
        price:10
    }
]

        // seed_certif:[{...initseed_certif}]

const request=[
    {
        name:"Public Seed Company",
        id:1
    },
     {
        name:"Public Research Institute",
        id:2
    },
    {
        name:"Private Seed Company",
        id:3
    },
    {
        name:"Farmers’ Cooperative",
        id:4
    },
    {
        name:"Others (precise)",
        id:5
    }
]

let init_item ={
        name:'',
        quantity:1,
        cost_per_kg:0,
        subtotal:0  
}

let initseed_certif ={
    name:'',
    quantity:1,
    cost_per:0
}
const payload = reactive({
    user:{
        full_name:"",
        phone:"",
        email:"",
        address:"",
        requester_type_id:null,
        custom_requester_type:""
    },
    order:{
        seed_class:"AfricaRice",
        total_quantity:0,
        total_cost:0
    },
    order_items:[{...init_item}],
})

const total_quantity = computed(() => {
    return payload.order_items.reduce((acc, item) => {
        return acc + Number(item.quantity || 0)
    }, 0)
})

const total_amount = computed(() => {
    return payload.order_items.reduce((acc, item) => {
        return acc + Number(item.cost_per_kg || 0)
    }, 0)
})

const addSeedClass =()=>{
    payload.order_items.push({...init_item})
}


const selectVariete =(event,index)=>{
  const selected = JSON.parse(event.target.value)
  payload.order_items[index].cost_per_kg = selected.price
  payload.order_items[index].name = selected.name
  onQuantity(index)
}

    const onQuantity =(index)=>{
        payload.order_items[index].subtotal = Number(payload.order_items[index].cost_per_kg) * Number(payload.order_items[index].quantity)
    }

    let loading = ref(false)

const removeSeedClass =(index)=>{
    payload.order_items.splice(index,1)
}

const addSeedCertif =()=>{
    payload.class_seed.seed_certif.push({...initseed_certif})
}

const removeSeedCertif =(index)=>{
    payload.class_seed.seed_certif.splice(index,1)
}

const handleSubmit=async()=>{
    if (payload.order_items.length === 0) {
        alert('Veuillez ajouter au moins un élément à la commande.')
        return
    }
    if (!confirm('Êtes-vous sûr de vouloir envoyer cette commande ?')) {
        return
    } 
    loading.value = true
    let items = {...payload}
    items.order.total_quantity = total_quantity.value
    items.order.total_cost = total_amount.value
    try {
    const response = await axios.post('/orders', items)
    alert('Commande envoyée avec succès !')
    console.log('Commande envoyée avec succès :', response.data)
    return response.data
  } catch (error) {
    console.error('Erreur lors de l’envoi :', error.response?.data || error.message)
    throw error
  } finally {
        loading.value = false
    }
}
onMounted(() => {
})
</script>


<template>
<div class="w-full bg-gray-50 flex-col min-h-screen flex items-center justify-center p-4 sm:p-6">
  <img src="/public/images/logo.webp" class="w-[150px] mb-5" alt="Mon Logo">
  <form @submit.prevent="handleSubmit" class="w-full max-w-6xl">
    <div class="w-full mx-auto p-6 sm:p-8 bg-white rounded-2xl border border-gray-300 flex flex-col md:flex-row gap-6 md:gap-10">
      
      <!-- Left Panel -->
      <div class="flex-1 space-y-8">

        <!-- General Info -->
        <div class="space-y-4">
          <h2 class="text-xl font-bold text-gray-800">Général informations</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Full Name -->
            <div>
              <label class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
              <input v-model="payload.user.full_name" type="text" required placeholder="Full name"
                     class="w-full text-sm border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Phone -->
            <div>
              <label class="block text-sm font-medium text-gray-600 mb-1">Phone</label>
              <input v-model="payload.user.phone" type="text" required placeholder="Phone"
                     class="w-full text-sm border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Email -->
            <div>
              <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
              <input v-model="payload.user.email" type="email" required placeholder="Email"
                     class="w-full text-sm border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Address -->
            <div>
              <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
              <input v-model="payload.user.address" type="text" required placeholder="Address"
                     class="w-full text-sm border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
          </div>

          <!-- Requester Type -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Type of requester</label>
            <select v-model="payload.user.requester_type_id" required
                    class="w-full text-sm border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option v-for="(item, index) in request" :value="item.id" :key="index">{{ item.name }}</option>
            </select>
          </div>

          <!-- Custom Requester Type -->
          <div v-if="payload.user.requester_type_id == 5">
            <label class="block text-sm font-medium text-gray-600 mb-1">Add requester type</label>
            <input v-model="payload.user.custom_requester_type" type="text" required placeholder="Add requester type"
                   class="w-full text-sm border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
        </div>

        <!-- Seed Class -->
        <div>
          <h2 class="text-xl font-bold text-gray-800">
            Class of Seed <span class="text-sm font-normal">(Please tick one option)</span>
          </h2>

          <!-- Radio Options -->
          <div class="mt-4 space-y-4">
            <div class="space-y-2">
              <label class="flex items-center gap-2">
                <input required type="radio" value="AfricaRice" v-model="payload.order.seed_class"
                       class="text-blue-600 focus:ring-blue-500">
                <span class="text-sm font-medium text-gray-700">AfricaRice Mandated Seed Classes</span>
              </label>

              <label class="flex items-center gap-2">
                <input required type="radio" value="Certified" v-model="payload.order.seed_class"
                       class="text-blue-600 focus:ring-blue-500">
                <span class="text-sm font-medium text-gray-700">Certified Seed</span>
              </label>
            </div>

            <!-- Dynamic AfricaRice Fields -->
            <div class="border border-gray-200 bg-gray-50 rounded-xl p-4 space-y-4">
              <div v-for="(item, index) in payload.order_items" :key="index" 
              class="border-b py-2 border-gray-200 flex flex-col md:flex-row gap-3 items-end">
                <div v-if="payload.order.seed_class === 'AfricaRice'" class="flex-1">
                  <label class="block text-sm font-medium text-gray-600 mb-1">Variety Type</label>
                  <select @change="(event) => selectVariete(event, index)"
                          class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option disabled value="">Variety Type</option>
                    <option v-for="(item, index) in type" :value="JSON.stringify(item)" :key="index">
                      {{ item.name }}
                    </option>
                  </select>
                </div>

                <div class="flex-1">
                  <label class="block text-sm font-medium text-gray-600 mb-1">Variety Name</label>
                  <input required v-model="payload.order_items[index].name" type="text" placeholder="Variety Name"
                         class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex-1">
                  <label class="block text-sm font-medium text-gray-600 mb-1">Quantity</label>
                  <input required min="1" type="number" @input="onQuantity(index)"
                         v-model="payload.order_items[index].quantity" placeholder="0"
                         class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex-1">
                  <label class="block text-sm font-medium text-gray-600 mb-1">Cost per Kg (US$)</label>
                  <input required v-model="payload.order_items[index].cost_per_kg" readonly disabled
                         class="w-full text-sm bg-gray-100 border border-gray-300 rounded-lg px-3 py-2 text-gray-700">
                </div>

                <button type="button" @click="removeSeedClass(index)"
                        class="text-red-600 hover:text-red-800 text-xl font-bold">×</button>
              </div>

              <button @click="addSeedClass" type="button"
                      class="text-sm border border-blue-500 text-blue-600 hover:bg-blue-50 rounded-lg px-4 py-2 transition">
                + Add New
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Summary Panel -->
      <div class="w-full md:w-[340px] bg-blue-50/30 rounded-2xl border border-blue-100 p-6 space-y-4 md:sticky md:top-4">
        <h3 class="text-xl font-semibold text-blue-800">Summary</h3>

        <div v-for="(item, index) in payload.order_items" :key="index"
             class="flex justify-between text-sm text-gray-800">
          <span class="w-[80%]">{{item.quantity}}× {{item.name}}</span>
          <span class="font-medium">{{ item.subtotal }} $</span>
        </div>

        <hr />

        <div class="flex justify-between text-sm text-gray-700">
          <span>Total quantity</span>
          <span>{{ total_quantity }}</span>
        </div>

        <div class="flex justify-between text-sm font-semibold text-gray-800">
          <span>Subtotal</span>
          <span>{{ total_amount }} $</span>
        </div>

        <div class="flex justify-between text-lg font-bold text-blue-900">
          <span>Due now</span>
          <span>{{ total_amount }} $</span>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg transition font-semibold">
          <span v-if="loading">Processing...</span>
          <span v-else>Submit now</span>
        </button>
      </div>
    </div>
  </form>
</div>


</template>
