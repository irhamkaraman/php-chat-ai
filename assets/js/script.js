document.addEventListener("DOMContentLoaded", () => {
  const boxes = document.querySelectorAll(".box");
  boxes.forEach((box) => {
    box.addEventListener("click", (event) => {
      const message = box.innerText.trim();
      sendMessage(message);
    });
  });
});

function sendPresetMessage(event, message) {
  event.preventDefault();

  const chatInput = document.getElementById("chat-input");
  chatInput.value = message;
  sendMessage(event);
}

function sendMessage(event) {
  event.preventDefault();

  const messageInput = document.getElementById("chat-input");
  const message = messageInput.value.trim();
  if (message === "") return;

  const container = document.querySelector(".container");

  const obrolanElement = document.getElementById("obrolan");
  if (obrolanElement) {
    obrolanElement.remove();
  }

  const messageElement = document.createElement("div");
  messageElement.className = "user-message";
  messageElement.textContent = message;
  container.appendChild(messageElement);

  const gapElement = document.createElement("div");
  gapElement.style.margin = "10px";
  container.appendChild(gapElement);

  const responseElement = document.createElement("div");
  responseElement.className = "chat-message ai-response loading";
  responseElement.textContent = "";
  container.appendChild(responseElement);

  const chatSendButton = document.getElementById("chat-send");
  if (chatSendButton) {
    chatSendButton.disabled = true;
    chatSendButton.innerHTML = '<div class="loading"></div>';
  }

  fetch("controller/ChatController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "message=" + encodeURIComponent(message),
  })
    .then((response) => response.json())
    .then((data) => {
      responseElement.classList.remove("loading");
      if (data.error) {
        console.error("Error:", data.error);
        const errorElement = document.createElement("div");
        errorElement.className = "chat-message error";
        errorElement.textContent = "Error: " + data.error;
        container.appendChild(errorElement);
      } else {
        const content = data.choices[0].message.content;
        const paragraphs = content.split("\n\n");

        paragraphs.forEach((paragraph) => {
          if (paragraph.startsWith("```")) {
            const codeParts = paragraph.split(/```[a-z]/).filter(Boolean);
            codeParts.forEach((codePart) => {
              const codeElement = document.createElement("div");
              codeElement.className = "code-block";
              codeElement.textContent = codePart.replace(/```/g);
              responseElement.appendChild(codeElement);
            });
          } else if (paragraph.endsWith("```")) {
            const codeElement = document.createElement("div");
            codeElement.className = "code-block";
            codeElement.textContent = paragraph;
            responseElement.appendChild(codeElement);
          }
           else if (paragraph.startsWith("1. ")) {
            const listElement = document.createElement("ol");
            if (paragraph.startsWith("** ")) {
              const boldText = paragraph.slice(2, -2);
              const boldElement = document.createElement("span");
              boldElement.className = "bold-text";
              boldElement.textContent = boldText;
              listElement.appendChild(boldElement);
            } else if (paragraph.startsWith("` ")) {
              const codeText = paragraph.slice(2, -2);
              const codeElement = document.createElement("code");
              codeElement.className = "inline-code";
              codeElement.textContent = codeText;
              listElement.appendChild(codeElement);
            }
            const listItems = paragraph.split(/^\d+\.\s/m).filter(Boolean);
            listItems.forEach((item) => {
              const listItem = document.createElement("li");
              listItem.textContent = item.trim();
              listElement.appendChild(listItem);
            });
            responseElement.appendChild(listElement);
          } else if (paragraph.startsWith("* ")) {
            const listElement = document.createElement("ul");
            const listItems = paragraph.split(/^\*\s/m).filter(Boolean);
            listItems.forEach((item) => {
              const listItem = document.createElement("li");
              listItem.textContent = item.trim();
              listElement.appendChild(listItem);
            });
            responseElement.appendChild(listElement);
          } else {
            const textElement = document.createElement("p");

            if (paragraph.includes("**")) {
              const boldText = paragraph.slice(2, -2);
              const boldElement = document.createElement("span");
              boldElement.className = "bold-text";
              boldElement.textContent = boldText;
              textElement.appendChild(boldElement);
            } else {
              textElement.textContent = paragraph;
            }

            responseElement.appendChild(textElement);
          }
        });

        fetch("controller/session.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "chat=true",
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              console.log("Session updated successfully");
            } else {
              console.error("Failed to update session");
            }
          })
          .catch((error) => {
            console.error("Error updating session:", error);
          });
      }
      if (chatSendButton) {
        chatSendButton.disabled = false;
        chatSendButton.innerHTML = "<span>Send</span>";
      }
      // Scroll to the bottom of the container
      container.scrollTop = container.scrollHeight;
    })
    .catch((error) => {
      responseElement.classList.remove("loading");
      console.error("Error:", error);
      const errorElement = document.createElement("div");
      errorElement.className = "chat-message error";
      errorElement.textContent = "Error: " + error;
      container.appendChild(errorElement);
      if (chatSendButton) {
        chatSendButton.disabled = false;
        chatSendButton.innerHTML = "<span>Send</span>";
      }
    });

  messageInput.value = "";
}
