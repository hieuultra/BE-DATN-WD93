<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <style>
        .body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        #chatbox {
            width: 350px;
            height: 500px;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow-y: auto;
            padding: 10px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        #inputContainer {
            display: flex;
            width: 350px;
        }

        #userInput {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s;
        }

        #userInput:focus {
            border-color: #007bff;
        }

        #sendButton {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-left: 10px;
        }

        #sendButton:hover {
            background-color: #0056b3;
        }

        .message {
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            max-width: 80%;
        }

        .user-message {
            background-color: #007bff;
            color: white;
            align-self: flex-start;
        }

        .bot-message {
            background-color: #e0e0e0;
            color: black;
            align-self: flex-end;
        }
    </style>
</head>

<body>
    @extends('layout')
    @section('content')
    <a href="{{route('viewSikibidi')}}" style="display: inline-block; text-decoration: none; color: white; background-color: #007bff; padding: 8px 12px; border-radius: 5px; font-weight: bold; transition: background-color 0.3s;">
        Quay lại
    </a>
    <style>
        a:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="body">
        <h1>CÁC CÂU TRẢ LỜI CHỈ MANG TÍNH CHẤT THAM KHẢO</h1>

        <div id="chatbotContainer">
            <div id="chatbox"></div>
            <div id="inputContainer">
                <input type="text" id="userInput" placeholder="Nhập câu hỏi bạn muốn hỏi..." />
                <button id="sendButton" class="btn btn-primary">Gửi</button>
            </div>
        </div>

        <div id="teachContainer" style="display: none;">
            <textarea id="textInput" rows="4" cols="50" placeholder="Nhập đoạn văn bản để dạy chatbot..."></textarea>
            <button id="teachButton" class="btn btn-success">Dạy Chatbot</button>
        </div>

        <button id="toggleButton" class="btn btn-secondary mt-3">Chuyển sang Dạy Chatbot</button>
    </div>



    <script>
        const toggleButton = document.getElementById('toggleButton');
        const chatbotContainer = document.getElementById('chatbotContainer');
        const teachContainer = document.getElementById('teachContainer');

        toggleButton.addEventListener('click', () => {
            if (chatbotContainer.style.display === 'none') {
                chatbotContainer.style.display = 'block';
                teachContainer.style.display = 'none';
                toggleButton.textContent = 'Chuyển sang Dạy Chatbot';
            } else {
                chatbotContainer.style.display = 'none';
                teachContainer.style.display = 'block';
                toggleButton.textContent = 'Chuyển sang Chatbot';
            }
        });

        const chatbox = document.getElementById('chatbox');
        const userInput = document.getElementById('userInput');
        const sendButton = document.getElementById('sendButton');

        const responses = {
            "đau đầu kéo dài": "Đau đầu dai dẳng hoặc thường xuyên, đặc biệt là đau nửa đầu, có thể là dấu hiệu của các vấn đề về thần kinh.",
            "mất trí nhớ và nhầm lẫn": "Suy giảm trí nhớ, khó tập trung và nhầm lẫn là những triệu chứng thường gặp ở bệnh Alzheimer và các rối loạn liên quan đến nhận thức.",
            "run tay chân": " Run rẩy không kiểm soát, đặc biệt ở tay và chân, có thể liên quan đến bệnh Parkinson hoặc rối loạn thần kinh khác",
            "đau đầu": "Bạn có thể xem xét khoa thần kinh để được tư vấn.",
            "co giật": "Co giật đột ngột hoặc động kinh là dấu hiệu của các bệnh liên quan đến hoạt động bất thường trong não, như động kinh.",
            "mất ngủ hoặc rối loạn giấc ngủ": "Mất ngủ hoặc rối loạn giấc ngủ kéo dài có thể là dấu hiệu của các vấn đề thần kinh, như rối loạn lo âu hoặc trầm cảm",
            "tê bì và yếu cơ": "Cảm giác tê bì, châm chích hoặc yếu ở tay, chân, có thể là triệu chứng của tổn thương dây thần kinh ngoại biên",
            "chóng mặt và mất thăng bằng": "Thường xuyên chóng mặt, mất thăng bằng hoặc khó duy trì tư thế có thể là dấu hiệu của các rối loạn hệ thần kinh tiền đình hoặc bệnh về não",
            "khó khăn trong vận động": "Cứng cơ, chậm chạp trong cử động hoặc khó khăn trong di chuyển có thể liên quan đến bệnh Parkinson hoặc các bệnh lý thần kinh vận động",
            "thay đổi cảm xúc và hành vi": "Các thay đổi về cảm xúc như lo âu, buồn bã, dễ kích động hoặc hành vi bất thường có thể là dấu hiệu của các rối loạn thần kinh như trầm cảm hoặc rối loạn lưỡng cực",
            "ảo giác và hoang tưởng": "Thấy hoặc nghe thấy những thứ không có thật, hoặc có suy nghĩ hoang tưởng là triệu chứng của các rối loạn tâm thần liên quan đến hệ thần kinh như tâm thần phân liệt",

            "đau đầu kéo dài": "Đau đầu dai dẳng hoặc thường xuyên, đặc biệt là đau nửa đầu, có thể là dấu hiệu của các vấn đề về thần kinh.",
            "mất trí nhớ và nhầm lẫn": "Suy giảm trí nhớ, khó tập trung và nhầm lẫn là những triệu chứng thường gặp ở bệnh Alzheimer và các rối loạn liên quan đến nhận thức.",
            "run tay chân": "Run rẩy không kiểm soát, đặc biệt ở tay và chân, có thể liên quan đến bệnh Parkinson hoặc rối loạn thần kinh khác.",
            "sưng khớp": "Sưng, đỏ hoặc nóng ở khớp, thường là dấu hiệu của viêm khớp, nhiễm trùng hoặc chấn thương.",
            "tiếng lục cục, lách cách ở khớp": "Âm thanh lạ khi di chuyển khớp có thể là dấu hiệu của tổn thương sụn khớp hoặc viêm xương khớp.",
            "chuột rút cơ": "Co cứng cơ không kiểm soát, thường kèm theo đau. Chuột rút có thể do mất nước, thiếu chất điện giải hoặc do vận động quá mức.",
            "đau lưng và cổ": "Đau ở vùng lưng hoặc cổ, có thể lan xuống chân hoặc tay. Đau lưng hoặc cổ thường là dấu hiệu của thoái hóa cột sống hoặc thoát vị đĩa đệm.",
            "loãng xương": "Loãng xương dẫn đến xương giòn, dễ gãy và thường gây đau âm ỉ ở cột sống hoặc xương dài.",
            "biến dạng khớp hoặc xương": "Biến dạng hình dáng của khớp hoặc xương có thể xảy ra do viêm khớp mãn tính hoặc các bệnh lý như viêm khớp dạng thấp.",
            "tê hoặc ngứa ran": "Tê, ngứa ran ở các chi có thể là dấu hiệu của chèn ép dây thần kinh ở cột sống hoặc các vấn đề về thần kinh ngoại biên liên quan đến cơ xương.",

            "đau đầu kéo dài": "Đau đầu dai dẳng hoặc thường xuyên, đặc biệt là đau nửa đầu, có thể là dấu hiệu của các vấn đề về thần kinh.",
            "mất trí nhớ và nhầm lẫn": "Suy giảm trí nhớ, khó tập trung và nhầm lẫn là những triệu chứng thường gặp ở bệnh Alzheimer và các rối loạn liên quan đến nhận thức.",
            "run tay chân": "Run rẩy không kiểm soát, đặc biệt ở tay và chân, có thể liên quan đến bệnh Parkinson hoặc rối loạn thần kinh khác.",
            "sưng khớp": "Sưng, đỏ hoặc nóng ở khớp, thường là dấu hiệu của viêm khớp, nhiễm trùng hoặc chấn thương.",
            "tiếng lục cục, lách cách ở khớp": "Âm thanh lạ khi di chuyển khớp có thể là dấu hiệu của tổn thương sụn khớp hoặc viêm xương khớp.",
            "đau thắt ngực": "Cảm giác đau, thắt hoặc nặng ở ngực, thường xuất hiện khi vận động hoặc căng thẳng. Đây là dấu hiệu phổ biến của bệnh mạch vành.",
            "khó thở": "Khó thở, đặc biệt là khi nằm hoặc khi gắng sức, có thể là dấu hiệu của suy tim hoặc các vấn đề tim mạch khác.",
            "tim đập nhanh hoặc không đều": "Cảm giác hồi hộp, tim đập nhanh, mạnh hoặc không đều có thể là triệu chứng của rối loạn nhịp tim.",
            "sưng chân hoặc mắt cá chân": "Phù nề ở chân, đặc biệt là mắt cá chân, có thể là dấu hiệu của suy tim hoặc suy chức năng của hệ tuần hoàn.",
            "chóng mặt và ngất xỉu": "Cảm giác chóng mặt, mất thăng bằng hoặc ngất xỉu đột ngột có thể là dấu hiệu của hạ huyết áp, nhịp tim bất thường hoặc các vấn đề tim mạch.",
            "đau hoặc khó chịu ở các khu vực khác của cơ thể": "Đau hoặc khó chịu ở lưng, cổ, hàm, vai hoặc cánh tay cũng có thể liên quan đến bệnh tim mạch.",
            "mệt mỏi kéo dài": "Cảm thấy mệt mỏi bất thường, đặc biệt là khi gắng sức nhẹ, có thể là dấu hiệu của suy tim hoặc bệnh tim khác.",
            "ra mồ hôi lạnh": "Đổ mồ hôi đột ngột, ngay cả khi không vận động, có thể là dấu hiệu của cơn đau tim.",

            "đau bụng dưới": "Đau bụng dưới có thể là dấu hiệu của các vấn đề liên quan đến buồng trứng, tử cung hoặc các rối loạn khác như lạc nội mạc tử cung.",
            "ra máu bất thường": "Ra máu âm đạo không theo chu kỳ kinh nguyệt có thể là dấu hiệu của các vấn đề như polyp, u xơ tử cung hoặc các rối loạn nghiêm trọng hơn.",
            "chu kỳ kinh nguyệt không đều": "Kinh nguyệt không đều có thể là dấu hiệu của rối loạn nội tiết tố, hội chứng buồng trứng đa nang (PCOS) hoặc các vấn đề về sức khỏe khác.",
            "đau khi quan hệ": "Cảm giác đau khi quan hệ tình dục có thể là dấu hiệu của các vấn đề về âm đạo, như khô âm đạo hoặc viêm nhiễm.",
            "tiểu khó hoặc đau khi tiểu": "Cảm giác đau hoặc khó khăn khi tiểu có thể là triệu chứng của nhiễm trùng đường tiểu hoặc các vấn đề về bàng quang.",
            "mệt mỏi kéo dài và thiếu sức sống": "Cảm giác mệt mỏi và thiếu năng lượng kéo dài có thể liên quan đến các vấn đề về nội tiết tố hoặc các rối loạn khác như thiếu máu.",
            "cảm giác nặng nề ở vùng chậu": "Cảm giác nặng nề hoặc áp lực ở vùng chậu có thể liên quan đến các khối u, u xơ hoặc các vấn đề khác trong vùng chậu.",
            "thay đổi ở ngực": "Sự thay đổi kích thước, hình dạng hoặc cảm giác ở ngực có thể là dấu hiệu của các vấn đề về vú, như u vú hoặc nhiễm trùng.",
            "dịch âm đạo bất thường": "Dịch âm đạo có màu sắc hoặc mùi bất thường có thể là dấu hiệu của nhiễm trùng, viêm hoặc các vấn đề khác liên quan đến sức khỏe phụ khoa.",
            "đau lưng dưới": "Đau lưng dưới có thể liên quan đến các vấn đề về cột sống hoặc có thể là triệu chứng của các rối loạn phụ khoa, như viêm vùng chậu.",

            "sốt cao": "Sốt cao ở trẻ em có thể là dấu hiệu của nhiều loại nhiễm trùng hoặc bệnh tật, cần được theo dõi và chăm sóc y tế kịp thời.",
            "ho kéo dài": "Ho kéo dài có thể là triệu chứng của viêm phổi, hen suyễn hoặc các bệnh lý hô hấp khác.",
            "nôn và tiêu chảy": "Nôn hoặc tiêu chảy có thể là dấu hiệu của ngộ độc thực phẩm, viêm dạ dày ruột hoặc các bệnh nhiễm trùng đường tiêu hóa.",
            "mệt mỏi bất thường": "Cảm giác mệt mỏi và thiếu năng lượng kéo dài có thể chỉ ra nhiều vấn đề sức khỏe khác nhau, từ thiếu máu đến bệnh lý nhiễm trùng.",
            "phát ban hoặc nổi mề đay": "Phát ban hoặc nổi mề đay có thể là dấu hiệu của phản ứng dị ứng, nhiễm trùng hoặc các bệnh da liễu.",
            "khó thở hoặc thở khò khè": "Khó thở hoặc thở khò khè có thể là triệu chứng của hen suyễn, viêm phổi hoặc các vấn đề hô hấp khác.",
            "đau bụng": "Đau bụng có thể liên quan đến nhiều vấn đề như viêm ruột thừa, nhiễm trùng đường tiêu hóa hoặc các rối loạn tiêu hóa khác.",
            "chảy nước mũi hoặc nghẹt mũi": "Chảy nước mũi hoặc nghẹt mũi có thể là triệu chứng của cảm lạnh thông thường, dị ứng hoặc viêm xoang.",
            "thay đổi hành vi hoặc tính cách": "Thay đổi trong hành vi hoặc tính cách có thể chỉ ra các vấn đề về tâm lý, căng thẳng hoặc trầm cảm ở trẻ em.",
            "ngứa ngáy hoặc kích ứng da": "Ngứa ngáy hoặc kích ứng da có thể là dấu hiệu của dị ứng, nhiễm trùng hoặc các bệnh về da như eczema."
        };
        responses["Tai Mũi Họng"] = "Tai Mũi Họng (TMH) là một chuyên khoa y tế tập trung vào các vấn đề liên quan đến tai, mũi và họng, cũng như các cấu trúc liên quan ở vùng đầu và cổ <a href='http://127.0.0.1:8000/appoinment/booKingCare/7' target='_blank'>liên kết này</a>";
        responses["Cơ Xương Khớp"] = "Cơ Xương Khớp là chuyên khoa y tế tập trung vào các vấn đề liên quan đến hệ thống cơ, xương và khớp trong cơ thể<a href='http://127.0.0.1:8000/appoinment/booKingCare/1' target='_blank'>liên kết này</a>";
        responses["Cột sống"] = "Cột sống là một bộ phận quan trọng của hệ cơ xương khớp, đóng vai trò như trụ chính của cơ thể, hỗ trợ và bảo vệ tủy sống, đồng thời cho phép cơ thể cử động linh hoạt <a href='http://127.0.0.1:8000/appoinment/booKingCare/4' target='_blank'>liên kết này</a>";

        function addMessage(sender, message) {
            const messageElement = document.createElement('div');
            if (sender === 'You') {
                messageElement.className = 'message user-message';
                messageElement.textContent = message;
            } else {
                messageElement.className = 'message bot-message';
                messageElement.innerHTML = message;
            }

            chatbox.appendChild(messageElement);
            chatbox.scrollTop = chatbox.scrollHeight;
        }

        async function fetchWikipediaSummary(keyword) {
            const url = `https://vi.wikipedia.org/api/rest_v1/page/summary/${encodeURIComponent(keyword)}`;
            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error('Không tìm thấy thông tin trên Wikipedia');

                const data = await response.json();

                return data.extract || "Không có thông tin chi tiết.";
            } catch (error) {
                console.error('Lỗi khi gọi Wikipedia API:', error);
                return "Xin lỗi, tôi chưa được dạy về điều đó.";
            }
        }

        let context = "";

        function updateContext(userMessage) {
            const lowerCaseMessage = userMessage.toLowerCase();
            for (const key in responses) {
                if (lowerCaseMessage.includes(key)) {
                    context = key;
                    return;
                }
            }
        }

        async function getBotResponse(userMessage) {
            const lowerCaseMessage = userMessage.toLowerCase();
            if (lowerCaseMessage.includes("tiếp tục") && context) {
                return responses[context];
            }

            for (const key in responses) {
                if (lowerCaseMessage.includes(key)) {
                    context = key;
                    return responses[key];
                }
            }

            const wikipediaResponse = await fetchWikipediaSummary(userMessage);
            return wikipediaResponse;
        }

        function teachBot(question, answer) {
            responses[question.toLowerCase()] = answer;
            saveResponses();
            console.log(`Bot đã được dạy câu hỏi "${question}" với câu trả lời "${answer}".`);
        }

        function saveResponses() {
            localStorage.setItem('botResponses', JSON.stringify(responses));
        }

        function loadResponses() {
            const savedResponses = localStorage.getItem('botResponses');
            if (savedResponses) {
                Object.assign(responses, JSON.parse(savedResponses));
            }
        }

        sendButton.addEventListener('click', async () => {
            const userMessage = userInput.value;
            if (userMessage) {
                addMessage('You', userMessage);

                if (userMessage.startsWith("teach: ")) {
                    const parts = userMessage.substring(7).split(" - ");
                    if (parts.length === 2) {
                        const question = parts[0].trim();
                        const answer = parts[1].trim();
                        teachBot(question, answer);
                        addMessage('Bot', "Cảm ơn! Tôi đã học câu hỏi mới.");
                    } else {
                        addMessage('Bot', "Cú pháp không đúng. Vui lòng nhập theo dạng: teach: câu hỏi - câu trả lời");
                    }
                } else {
                    const botResponse = await getBotResponse(userMessage);
                    addMessage('Bot', botResponse);
                    updateContext(userMessage);
                }

                userInput.value = '';
            }
        });

        function teachBotFromText(text) {
            const sentences = text.split('. ');

            let context = '';

            sentences.forEach(sentence => {
                if (sentence.includes('là') || sentence.includes('cách') || sentence.includes('tại sao')) {
                    const [question, answer] = sentence.split('là');

                    if (question && answer) {
                        const formattedQuestion = question.trim();
                        const formattedAnswer = answer.trim();
                        responses[formattedQuestion.toLowerCase()] = formattedAnswer;
                        saveResponses();
                        console.log(`Đã thêm câu hỏi "${formattedQuestion}" với câu trả lời "${formattedAnswer}".`);
                        context = formattedQuestion.toLowerCase();
                    }
                } else if (context) {
                    responses[context] += ' ' + sentence.trim();
                    saveResponses();
                    console.log(`Đã cập nhật ngữ cảnh "${context}" với thông tin bổ sung: "${sentence.trim()}".`);
                }
            });
        }

        const teachButton = document.getElementById('teachButton');
        const textInput = document.getElementById('textInput');

        teachButton.addEventListener('click', () => {
            const userInputText = textInput.value;

            if (userInputText) {
                teachBotFromText(userInputText);
                textInput.value = '';
                alert("Chatbot đã được dạy từ đoạn văn bản!");
            } else {
                alert("Vui lòng nhập đoạn văn bản để dạy chatbot.");
            }
        });

        userInput.addEventListener('keypress', (event) => {
            if (event.key === 'Enter') {
                sendButton.click();
            }
        });
        loadResponses();
    </script>
    @endsection
</body>

</html>