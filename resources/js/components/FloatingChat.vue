<template>
  <div class="fixed bottom-4 right-4 z-50">
    <!-- Botão flutuante -->
    <button
      @click="toggleChat"
      class="w-14 h-14 rounded-full bg-blue-700 text-white shadow-lg flex items-center justify-center text-xl"
    >
      💬
    </button>

    <!-- Janela do chat -->
    <div
      v-if="chatOpen"
      class="w-[400px] h-[600px] bg-white rounded-xl shadow-xl flex flex-col overflow-hidden mt-4"
    >
      <div class="bg-blue-700 text-white px-4 py-2 text-sm font-bold flex justify-between items-center">
        <span>Assistente Virtual UCM</span>
        <button @click="toggleChat" class="text-white">✖</button>
      </div>

      <div class="flex-1 p-3 overflow-y-auto text-sm space-y-2" ref="messageBox">
        <div v-for="(msg, index) in messages" :key="index" :class="msg.from === 'user' ? 'text-right' : 'text-left'">
          <div :class="msg.from === 'user' ? 'bg-green-100' : 'bg-gray-100'" class="inline-block px-3 py-2 rounded">
            {{ msg.text }}
          </div>
        </div>
      </div>

      <div class="p-2 border-t">
        <input
          v-model="input"
          @keyup.enter="send"
          class="w-full px-3 py-2 border rounded text-sm"
          placeholder="Digite sua mensagem ou número da opção..."
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, nextTick, onMounted } from 'vue';

const chatOpen = ref(false);
const input = ref('');
const messages = ref<{ from: string; text: string }[]>([]);
const currentQuestionId = ref<number | null>(null);
const answersMap = ref<{ [key: string]: number }>({}); // mapa de resposta -> id

const messageBox = ref<HTMLElement | null>(null);

const toggleChat = () => {
  chatOpen.value = !chatOpen.value;
  if (chatOpen.value && messages.value.length === 0) {
    startChat();
  }
  nextTick(() => {
    messageBox.value?.scrollTo({ top: messageBox.value.scrollHeight });
  });
};

const startChat = async () => {
  // Primeira pergunta
  const res = await fetch('/api/frontend-chatbot');
  const data = await res.json();

  currentQuestionId.value = data.id;
  messages.value.push({ from: 'bot', text: data.message });

  answersMap.value = {};
  data.answers.forEach((ans: any, i: number) => {
    const opt = `${i + 1}️⃣ ${ans.label}`;
    messages.value.push({ from: 'bot', text: opt });
    answersMap.value[(i + 1).toString()] = ans.id;
  });
};

const send = async () => {
  const text = input.value.trim();
  if (!text) return;

  messages.value.push({ from: 'user', text });
  input.value = '';

  // Verifica se é uma resposta válida
  const answerId = answersMap.value[text];
  if (!answerId) {
    messages.value.push({ from: 'bot', text: 'Por favor, selecione uma opção válida (ex: 1, 2, 3...)' });
    return;
  }

  try {
    const response = await fetch('/api/frontend-chatbot/answer', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ input: answerId }),
    });

    const data = await response.json();

    if (data.type === 'question') {
      const res = await fetch(`/api/frontend-chatbot/question/${data.id}`);
      const qData = await res.json();

      currentQuestionId.value = qData.id;
      messages.value.push({ from: 'bot', text: qData.body });

      answersMap.value = {};
      qData.answers.forEach((ans: any, i: number) => {
        const opt = `${i + 1}️⃣ ${ans.title}`;
        messages.value.push({ from: 'bot', text: opt });
        answersMap.value[(i + 1).toString()] = ans.id;
      });
    } else {
      messages.value.push({ from: 'bot', text: data.response });
    }
  } catch (err) {
    messages.value.push({ from: 'bot', text: 'Erro ao comunicar com o servidor.' });
  }

  nextTick(() => {
    messageBox.value?.scrollTo({ top: messageBox.value.scrollHeight });
  });
};
</script>

<style scoped>
::-webkit-scrollbar {
  width: 4px;
}
::-webkit-scrollbar-thumb {
  background-color: rgba(0, 0, 0, 0.2);
  border-radius: 2px;
}
</style>