/**
 * js特效
 */
function wx()
{
	var wx = new Object();
		wx.relphone =/^0?(13|14|15|17|18)[0-9]{9}$/;
		wx.relemail =/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/;
		wx.request = {};
		wx.group = {};	
		/**
		 * element           MOD节点对像          如：.class 或 #id ，元素对像
		 * 
		 * events        	 event                js事件               
		 * 
		 * method        	 function             处理方法 
		 * */
		wx.ActionEvents = function(parameter)
		{
			wx.group = parameter	
			wx.obj = $(wx.group.element);
			$(wx.group.element).on(wx.group.events,wx.group.method);
		}
	
	return wx
}

var wx = new wx();