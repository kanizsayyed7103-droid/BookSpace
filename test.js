import fetch from "node-fetch";

const GEMINI_API_KEY = "YAIzaSyA6IYaleLMwVFMIQGXiuDSqv4kbT0DlmFI";

async function testKey() {
  const response = await fetch(
    `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${GEMINI_API_KEY}`,
    {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        contents: [
          { role: "user", parts: [{ text: "Say Hello if my API key works!" }] }
        ]
      })
    }
  );

  const data = await response.json();
  console.log(JSON.stringify(data, null, 2));
}

testKey();
