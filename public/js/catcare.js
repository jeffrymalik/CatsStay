
        function showDetail(name, imageUrl) {
            document.getElementById('detailPage').classList.add('active');
            document.getElementById('cardsGrid').classList.add('hidden');
            document.getElementById('filterSection').classList.add('hidden');
            document.getElementById('detailName').textContent = name;
            document.getElementById('detailProfileImage').src = imageUrl;
            window.scrollTo(0, 0);
        }

        function showCards() {
            document.getElementById('detailPage').classList.remove('active');
            document.getElementById('cardsGrid').classList.remove('hidden');
            document.getElementById('filterSection').classList.remove('hidden');
            window.scrollTo(0, 0);
        }
