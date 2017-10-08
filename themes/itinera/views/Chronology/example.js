
    <script type="text/javascript">
      $(document).ready(function(){

      var events = [
      {dates: [new Date(2015, 3, 5)], title: "2015 Season Opener", section: 0},
      {dates: [new Date(2016, 1, 28)], title: "Spring Training Begins", section: 2},
      {dates: [new Date(2016, 4, 20)], title: "Brewers @ Mets Game 1", section: 1},
      {dates: [new Date(2016, 4, 21)], title: "Brewers @ Mets Game 2", section: 1},
      {dates: [new Date(2016, 4, 22)], title: "Brewers @ Mets Game 3", section: 1},
      {dates: [new Date(2016, 4, 23), new Date(2016, 4, 25)], title: "Mets @ Nationals", section: 1},
      {dates: [new Date(2016, 4, 23), new Date(2016, 4, 25)], title: "Phillies @ Tigers", section: 1},
      {dates: [new Date(2016, 4, 23), new Date(2016, 4, 26)], title: "Diamondbacks @ Pirates", section: 1},
      {dates: [new Date(2016, 4, 26), new Date(2016, 4, 28)], title: "Cardinals @ Nationals", section: 1},
      {dates: [new Date(2016, 6, 12)], title: "All-Star Game", section: 1},
      {dates: [new Date(2016, 9, 24)], title: "World Series Begins", section: 3}
      ];

      var sections = [
      {dates: [new Date(2015, 3, 5), new Date(2015, 10, 2)], title: "2015 MLB Regular Season", section: 0, attrs: {fill: "#d4e3fd"}},
      {dates: [new Date(2016, 3, 3), new Date(2016, 9, 2)], title: "2016 MLB Season", section: 1, attrs: {fill: "#d4e3fd"}},
      {dates: [new Date(2016, 1, 28), new Date(2016, 3, 2)], title: "Spring Training", section: 2, attrs: {fill: "#eaf0fa"}},
      {dates: [new Date(2016, 9, 3), new Date(2016, 9, 31)], title: "2016 MLB Playoffs", section: 3, attrs: {fill: "#eaf0fa"}}
      ];

      var timeline1 = new Chronoline(document.getElementById("target1"), events,
        {animated: true,
         tooltips: true,
         defaultStartDate: new Date(2016, 4, 17),
         sections: sections,
         sectionLabelAttrs: {'fill': '#997e3d', 'font-weight': 'bold'},
      });

      $('#to-today').click(function(){timeline1.goToToday();});

      var sections2 = [
      {dates: [new Date(2015, 3, 5), new Date(2015, 10, 2)], title: "2015 MLB Regular Season", section: 0, attrs: {fill: "#e3f0fe"}},
      {dates: [new Date(2016, 3, 3), new Date(2016, 9, 2)], title: "2016 MLB Season", section: 1, attrs: {fill: "#e3f0fe"}},
      {dates: [new Date(2016, 1, 28), new Date(2016, 3, 2)], title: "Spring Training", section: 2, attrs: {fill: "#cce5ff"}},
      {dates: [new Date(2016, 9, 3), new Date(2016, 9, 31)], title: "2016 MLB Playoffs", section: 3, attrs: {fill: "#cce5ff"}}
      ];

      var timeline2 = new Chronoline(document.getElementById("target2"), events,
        {visibleSpan: DAY_IN_MILLISECONDS * 91,
      animated: true,
         tooltips: true,
         defaultStartDate: new Date(2016, 4, 1),
         sections: sections2,
         sectionLabelAttrs: {'fill': '#997e3d', 'font-weight': 'bold'},
      labelInterval: isFifthDay,
      hashInterval: isFifthDay,
      scrollLeft: prevMonth,
      scrollRight: nextMonth,
      markToday: 'labelBox',
         draggable: true
      });

      var timeline3 = new Chronoline(document.getElementById("target3"), events,
        {visibleSpan: DAY_IN_MILLISECONDS * 366,
      animated: true,
         tooltips: true,
         defaultStartDate: new Date(2016, 4, 25),
         sections: sections,
         sectionLabelAttrs: {'fill': '#997e3d', 'font-weight': 'bold'},
      labelInterval: isHalfMonth,
      hashInterval: isHalfMonth,
      scrollLeft: prevQuarter,
      scrollRight: nextQuarter,
      floatingSubLabels: false,
      });

      $('#zoom').click(function() {
          timeline3.zoom(parseFloat($('#zoom-factor').val()));
      });

      });
    </script>
    
   